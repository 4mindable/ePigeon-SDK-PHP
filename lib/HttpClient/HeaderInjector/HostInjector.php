<?php


namespace Epigeon\HttpClient\HeaderInjector;

use Epigeon\HttpClient\HeaderInjectorInterface;
use Epigeon\HttpClient\HttpRequest;

/**
 * Class HostInjector
 * @package Epigeon\HttpClient\HeaderInjector
 */
class HostInjector implements HeaderInjectorInterface
{
    private string $host;

    /**
     * HostInjector constructor
     *
     * @param string $host
     */
    public function __construct(string $host)
    {
        $this->host = $host;
    }

    /**
     * function inject
     *
     * @param HttpRequest $http_request
     *
     * @return void
     */
    public function inject(HttpRequest $http_request): void
    {
        if(!empty($this->host)){
            $http_request->headers["Host"] = $this->host;
        }
    }
}