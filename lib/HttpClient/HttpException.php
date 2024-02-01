<?php


namespace Epigeon\HttpClient;

class HttpException extends \Exception
{
    /**
     * @var int
     */
    public $statusCode;

    /**
     * @var array
     */
    public $headers;

    /**
     * @param string $message
     * @param int $statusCode
     * @param array $headers
     */
    public function __construct( string $message, int $statusCode, array $headers = [])
    {
        parent::__construct($message);
        $this->statusCode = $statusCode;
        $this->headers = $headers;
    }
}
