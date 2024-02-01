<?php


namespace Epigeon\HttpClient\HeaderInjector;

use Epigeon\HttpClient\HeaderInjectorInterface;
use Epigeon\HttpClient\HttpRequest;

/**
 * Class FetchInjector
 * @package Epigeon\HttpClient\HeaderInjector
 */
class FetchInjector implements HeaderInjectorInterface
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
        $http_request->headers["Sec-Fetch-Dest"] = "empty";
        $http_request->headers["Sec-Fetch-Mode"] = "cors";
        $http_request->headers["Sec-Fetch-Site"] = "same-origin";
    }
}