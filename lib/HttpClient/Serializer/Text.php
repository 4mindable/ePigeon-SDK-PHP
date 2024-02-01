<?php

namespace Epigeon\HttpClient\Serializer;

use Epigeon\HttpClient\HttpRequest;
use Epigeon\HttpClient\SerializerInterface;

/**
 * Class Text
 * @package Epigeon\HttpClient\Serializer
 *
 * Serializer for Text content types.
 */
class Text implements SerializerInterface
{
    /**
     * function contentType
     *
     * @return string
     */
    public function contentType(): string
    {
        return "/^text\\/.*/";
    }

    /**
     * function encode
     *
     * @param HttpRequest $request
     *
     * @return false|string
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
        return implode(" ", $body);
    }

    /**
     * function decode
     *
     * @param $data
     *
     * @return mixed
     */
    public function decode($data)
    {
        return $data;
    }
}
