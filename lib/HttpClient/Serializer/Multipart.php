<?php

namespace Epigeon\HttpClient\Serializer;

use finfo;
use Epigeon\HttpClient\HttpRequest;
use Epigeon\HttpClient\SerializerInterface;
use Epigeon\HttpClient\Encoder;
use Epigeon\HttpClient\Serializer\FormPart;

/**
 * Class Multipart
 * @package Epigeon\HttpClient\Serializer
 *
 * Serializer for multipart.
 */
class Multipart implements SerializerInterface
{
    const LINEFEED = "\r\n";

    /**
     * function contentType
     *
     * @return string
     */
    public function contentType(): string
    {
        return "/^multipart\/.*$/";
    }

    /**
     * function encode
     *
     * @param HttpRequest $request
     *
     * @return string
     * @throws \Exception
     */
    public function encode(HttpRequest $request): string
    {
        if (!is_array($request->body) || !$this->isAssociative($request->body))
        {
            throw new \Exception("HttpRequest body must be an associative array when Content-Type is: " . $request->headers["content-type"]);
        }
        $boundary = "---------------------" . md5(mt_rand() . microtime());
        $contentTypeHeader = $request->headers["content-type"];
        $request->headers["content-type"] = "{$contentTypeHeader}; boundary={$boundary}";

        $value_params = [];
        $file_params = [];

        $disallow = ["\0", "\"", "\r", "\n"];

        $body = [];

        foreach ($request->body as $k => $v) {
            $k = str_replace($disallow, "_", $k);
            if (is_resource($v)) {
                $file_params[] = $this->prepareFilePart($k, $v, $boundary);
            } else if ($v instanceof FormPart) {
                $value_params[] = $this->prepareFormPart($k, $v, $boundary);
            } else {
                $value_params[] = $this->prepareFormField($k, $v, $boundary);
            }
        }

        $body = array_merge($value_params, $file_params);

        // add boundary for each parameters
        array_walk($body, function (&$part) use ($boundary) {
            $part = "--{$boundary}" . self::LINEFEED . "{$part}";
        });

        // add final boundary
        $body[] = "--{$boundary}--";
        $body[] = "";

        return implode(self::LINEFEED, $body);
    }

    /**
     * function decode
     *
     * @param $data
     *
     * @return mixed
     * @throws \Exception
     */
    public function decode($data)
    {
        throw new \Exception("Multipart does not support deserialization");
    }

    /**
     * function isAssociative
     *
     * @param array $array
     *
     * @return bool
     */
    private function isAssociative(array $array)
    {
        return array_values($array) !== $array;
    }

    /**
     * function prepareFormField
     *
     * @param $partName
     * @param $value
     * @param $boundary
     *
     * @return string
     */
    private function prepareFormField($partName, $value, $boundary): string
    {
        return implode(self::LINEFEED, [
            "Content-Disposition: form-data; name=\"{$partName}\"",
            "",
            filter_var($value),
        ]);
    }

    /**
     * function prepareFilePart
     *
     * @param $partName
     * @param $file
     * @param $boundary
     *
     * @return string
     */
    private function prepareFilePart($partName, $file, $boundary): string
    {
        $fileInfo = new finfo(FILEINFO_MIME_TYPE);
        $filePath = stream_get_meta_data($file)['uri'];
        $data = file_get_contents($filePath);
        $mimeType = $fileInfo->buffer($data);

        $splitFilePath = explode(DIRECTORY_SEPARATOR, $filePath);
        $filePath = end($splitFilePath);
        $disallow = ["\0", "\"", "\r", "\n"];
        $filePath = str_replace($disallow, "_", $filePath);
        return implode(self::LINEFEED, [
            "Content-Disposition: form-data; name=\"{$partName}\"; filename=\"{$filePath}\"",
            "Content-Type: {$mimeType}",
            "",
            $data,
        ]);
    }

    /**
     * function prepareFormPart
     *
     * @param $partName
     * @param $formPart
     * @param $boundary
     *
     * @return string
     * @throws \Exception
     */
    private function prepareFormPart($partName, $formPart, $boundary): string
    {
        $contentDisposition = "Content-Disposition: form-data; name=\"{$partName}\"";

        $partHeaders = $formPart->getHeaders();
        $formatted_headers = array_change_key_case($partHeaders);
        if (array_key_exists("content-type", $formatted_headers)) {
            if ($formatted_headers["content-type"] === "application/json") {
                $contentDisposition .= "; filename=\"{$partName}.json\"";
            }
            $tempRequest = new HttpRequest('/', 'POST');
            $tempRequest->headers = $formatted_headers;
            $tempRequest->body = $formPart->getValue();
            $encoder = new Encoder();
            $partValue = $encoder->serializeRequest($tempRequest);
        } else {
            $partValue = $formPart->getValue();
        }

        $finalPartHeaders = [];
        foreach ($partHeaders as $k => $v) {
            $finalPartHeaders[] = "{$k}: {$v}";
        }

        $body = array_merge([$contentDisposition], $finalPartHeaders, [""], [$partValue]);

        return implode(self::LINEFEED, $body);
    }
}
