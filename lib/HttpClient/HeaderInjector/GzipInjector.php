<?php


namespace Epigeon\HttpClient\HeaderInjector;

use Epigeon\HttpClient\HeaderInjectorInterface;
use Epigeon\HttpClient\HttpRequest;

/**
 * Class GzipInjector
 * @package Epigeon\HttpClient\HeaderInjector
 */
class GzipInjector implements HeaderInjectorInterface
{
    /**
     * function inject
     *
     * @param HttpRequest $http_request
     *
     * @return void
     */
    public function inject(HttpRequest $http_request): void
    {
        $http_request->headers["Accept-Encoding"] = "gzip";
    }
}