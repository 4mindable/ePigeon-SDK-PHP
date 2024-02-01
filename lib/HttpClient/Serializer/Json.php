<?php

namespace Epigeon\HttpClient\Serializer;

use Epigeon\HttpClient\HttpRequest;
use Epigeon\HttpClient\SerializerInterface;

/**
 * Class Json
 * @package Epigeon\HttpClient\Serializer
 *
 * Serializer for JSON content types.
 */
class Json implements SerializerInterface
{
    /**
     * function contentType
     *
     * @return string
     */
    public function contentType(): string
    {
        return "/^application\\/json/";
    }

    /**
     * function encode
     *
     * @param HttpRequest $request
     *
     * @return false|string
     * @throws \Exception
     */
    public function encode(HttpRequest $request): false|string
    {
        $body = $request->body;
        if (is_string($body)) {
            return $body;
        }
        if (is_array($body)) {
            return json_encode($body);
        }
        throw new \Exception("Cannot serialize data. Unknown type");
    }

    public function decode($data)
    {
        return json_decode($data);
    }
}
