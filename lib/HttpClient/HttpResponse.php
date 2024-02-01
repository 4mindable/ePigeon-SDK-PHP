<?php


namespace Epigeon\HttpClient;

/**
 * Class HttpResponse
 * @package Epigeon\HttpClient
 *
 * Object that holds your response details
 */
class HttpResponse
{
    /**
     * @var int
     */
    public $statusCode;

    /**
     * @var array | string | object
     */
    public $result;

    /**
     * @var array
     */
    public $headers;

    public function __construct($statusCode, $body, $headers)
    {
        $this->statusCode = $statusCode;
        $this->headers = $headers;
        $this->result = $body;
    }

    /**
     * function getResponse
     *
     * @return array|object|string
     */
    public function getResponse(): object|array|string
    {
        return $this->result;
    }
}
