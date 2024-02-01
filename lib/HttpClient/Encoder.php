<?php

namespace Epigeon\HttpClient;

use Epigeon\HttpClient\Serializer\Form;
use Epigeon\HttpClient\Serializer\Json;
use Epigeon\HttpClient\Serializer\Multipart;
use Epigeon\HttpClient\Serializer\Text;

/**
 * Class Encoder
 * @package Epigeon\HttpClient
 *
 * Encoding class for serializing and deserializing request/response.
 */
class Encoder
{
    private array $serializers = [];

    /**
     * Encoder constructor.
     */
    function __construct()
    {
        $this->serializers[] = new Json();
        $this->serializers[] = new Text();
        $this->serializers[] = new Multipart();
        $this->serializers[] = new Form();
    }

    /**
     * function serializeRequest
     *
     * @param HttpRequest $request
     *
     * @return false|string
     * @throws \Exception
     */
    public function serializeRequest(HttpRequest $request): false|string
    {
        if (!array_key_exists('Content-Type', $request->headers)) {
            var_export($request->headers);
            $message = "HttpRequest does not have Content-Type header set";
            echo $message;
            throw new \Exception($message);
        }

        $content_type = $request->headers['Content-Type'];
        /** @var SerializerInterface $serializer */
        $serializer = $this->serializer($content_type);

        if (is_null($serializer)) {
            $message = sprintf("Unable to serialize request with Content-Type: %s. Supported encodings are: %s", $content_type, implode(", ", $this->supportedEncodings()));
            echo $message;
            throw new \Exception($message);
        }

        if (!(is_string($request->body) || is_array($request->body))) {
            $message = "Body must be either string or array";
            echo $message;
            throw new \Exception($message);
        }

        $serialized = $serializer->encode($request);

        if (array_key_exists("content-encoding", $request->headers) && $request->headers["content-encoding"] === "gzip") {
            $serialized = gzencode($serialized);
        }
        return $serialized;
    }

    /**
     * function deserializeResponse
     *
     * @param $responseBody
     * @param $headers
     *
     * @return mixed
     * @throws \Exception
     */
    public function deserializeResponse($responseBody, $headers): mixed
    {

        if (!array_key_exists('content-type', $headers)) {
            $message = "HTTP response does not have Content-Type header set";
            echo $message;
            throw new \Exception($message);
        }

        $contentType = $headers['content-type'];
        $contentType = strtolower($contentType);
        /** @var SerializerInterface $serializer */
        $serializer = $this->serializer($contentType);

        if (is_null($serializer)) {
            throw new \Exception(sprintf("Unable to deserialize response with Content-Type: %s. Supported encodings are: %s", $contentType, implode(", ", $this->supportedEncodings())));
        }

        if (array_key_exists("content-encoding", $headers) && $headers["content-encoding"] === "gzip") {
            $responseBody = gzdecode($responseBody);
        }

        return $serializer->decode($responseBody);
    }

    /**
     * function serializer
     *
     * @param $contentType
     *
     * @return SerializerInterface|null
     * @throws \Exception
     */
    private function serializer($contentType): ?SerializerInterface
    {
        /** @var SerializerInterface $serializer */
        foreach ($this->serializers as $serializer) {
            try {
                if (preg_match($serializer->contentType(), $contentType) == 1) {
                    return $serializer;
                }
            } catch (\Exception $ex) {
                $message = sprintf("Error while checking content type of %s: %s", get_class($serializer), $ex->getMessage());
                echo $message;
                throw new \Exception($message, $ex->getCode(), $ex);
            }
        }

        return null;
    }

    /**
     * function supportedEncodings
     *
     * @return array
     */
    private function supportedEncodings(): array
    {
        $values = [];
        /** @var SerializerInterface $serializer */
        foreach ($this->serializers as $serializer) {
            $values[] = $serializer->contentType();
        }
        return $values;
    }
}
