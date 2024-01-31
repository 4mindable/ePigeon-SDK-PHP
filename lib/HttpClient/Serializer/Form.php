<?php

namespace Epigeon\HttpClient\Serializer;

use Epigeon\HttpClient\HttpRequest;
use Epigeon\HttpClient\SerializerInterface;

class Form implements SerializerInterface
{
    /**
     * @return string Regex that matches the content type it supports.
     */
    public function contentType()
    {
        return "/^application\/x-www-form-urlencoded$/";
    }

    /**
     * function encode
     *
     * @param HttpRequest $request
     *
     * @return string
     * @throws \Exception
     */
    public function encode(HttpRequest $request)
    {
        if (!is_array($request->body) || !$this->isAssociative($request->body))
        {
            throw new \Exception("HttpRequest body must be an associative array when Content-Type is: " . $request->headers["Content-Type"]);
        }

        return http_build_query($request->body);
    }

    /**
     * @param $body
     * @return mixed
     * @throws \Exception as multipart does not support deserialization.
     */
    public function decode($body)
    {
        throw new \Exception("CurlSupported does not support deserialization");
    }

    private function isAssociative(array $array)
    {
        return array_values($array) !== $array;
    }
}
