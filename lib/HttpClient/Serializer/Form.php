<?php

namespace Epigeon\HttpClient\Serializer;

use Epigeon\HttpClient\HttpRequest;
use Epigeon\HttpClient\SerializerInterface;

/**
 * Class Form
 * @package Epigeon\HttpClient\Serializer
 */
class Form implements SerializerInterface
{
    /**
     * function contentType
     *
     * @return string Regex that matches the content type it supports.
     */
    public function contentType(): string
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
    public function encode(HttpRequest $request): string
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
    public function decode($body): mixed
    {
        throw new \Exception("CurlSupported does not support deserialization");
    }

    /**
     * function isAssociative
     *
     * @param array $array
     *
     * @return bool
     */
    private function isAssociative(array $array): bool
    {
        return array_values($array) !== $array;
    }
}
