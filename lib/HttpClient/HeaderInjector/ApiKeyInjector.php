<?php

namespace Epigeon\HttpClient\HeaderInjector;

use Epigeon\HttpClient\HeaderInjectorInterface;
use Epigeon\HttpClient\HttpRequest;

/**
 * Class ApiKeyInjector
 * @package Epigeon\Api
 */
class ApiKeyInjector implements HeaderInjectorInterface
{
    private $client_key;

    /**
     * ApiKeyInjector constructor.
     * @param string $client_key
     */
    public function __construct(string $client_key)
    {
        $this->client_key = $client_key;
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
        $http_request->headers["X-API-KEY"] = $this->client_key;
    }
}