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

    public function contentType()
    {
        return "/^text\\/.*/";
    }

    public function encode(HttpRequest $request)
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

    public function decode($data)
    {
        return $data;
    }
}
