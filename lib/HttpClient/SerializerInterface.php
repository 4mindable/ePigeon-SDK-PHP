<?php
/*
 * Blogs Herder Editorial
 * (C) 2022 - Herder Editorial SL, Barcelona
 *
 * @author: Luis M. Bodero
 * Date: 2022-7-22
 */

namespace Epigeon\HttpClient;

/**
 * Interface Serializer
 * @package Epigeon\HttpClient
 *
 * Used to implement different serializers for different content types
 */
interface SerializerInterface
{
    /**
     * @return string Regex that matches the content type it supports.
     */
    public function contentType();

    /**
     * @param HttpRequest $request
     * @return string representation of your data after being serialized.
     */
    public function encode(HttpRequest $request);

    /**
     * @param $body
     * @return mixed object/string representing the de-serialized response body.
     */
    public function decode($body);
}
