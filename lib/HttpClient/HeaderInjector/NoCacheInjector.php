<?php


namespace Epigeon\HttpClient\HeaderInjector;

use Epigeon\HttpClient\HeaderInjectorInterface;
use Epigeon\HttpClient\HttpRequest;

/**
 * Class NoCacheInjector
 * @package Epigeon\HttpClient\HeaderInjector
 */
class NoCacheInjector implements HeaderInjectorInterface
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
        $http_request->headers["Cache-Control"] = "no-cache";
        $http_request->headers["Pragma"] = "no-cache";
    }
}