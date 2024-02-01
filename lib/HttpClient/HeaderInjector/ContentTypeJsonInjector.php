<?php


namespace Epigeon\HttpClient\HeaderInjector;

use Epigeon\HttpClient\HeaderInjectorInterface;
use Epigeon\HttpClient\HttpRequest;

/**
 * Class ContentTypeJsonInjector
 * @package Epigeon\HttpClient\HeaderInjector
 */
class ContentTypeJsonInjector implements HeaderInjectorInterface
{
    const CONTENT_TYPE = 'application/json';

    /**
     * function inject
     *
     * @param HttpRequest $http_request
     *
     * @return void
     */
    public function inject(HttpRequest $http_request): void
    {
        $http_request->headers["Content-Type"] = self::CONTENT_TYPE;
    }
}