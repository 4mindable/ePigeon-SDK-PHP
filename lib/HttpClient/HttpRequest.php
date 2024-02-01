<?php


namespace Epigeon\HttpClient;

/**
 * Class HttpRequest
 * @package Epigeon\HttpClient
 *
 * Request object that holds all the necessary information required by HTTPClient
 *
 * @see HttpClientAbstract
 */
class HttpRequest
{
    /**
     * @var string
     */
    public $path;

    /**
     * @var array | string
     */
    public $body;

    /**
     * @var string
     */
    public $verb;

    /**
     * @var array
     */
    public $headers;

    function __construct($path, $verb)
    {
        $this->path = $path;
        $this->verb = $verb;
        $this->body = NULL;
        $this->headers = [];
    }

    /**
     * function setBody
     *
     * @param array $arguments
     *
     * @return void
     */
    public function setBody(array $arguments) {
        $this->body = $arguments;
    }
}
