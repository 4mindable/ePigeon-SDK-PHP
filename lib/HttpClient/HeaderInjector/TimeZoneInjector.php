<?php

namespace Epigeon\HttpClient\HeaderInjector;

use Epigeon\HttpClient\HeaderInjectorInterface;
use Epigeon\HttpClient\HttpRequest;

/**
 * Class TimeZoneInjector
 * @package Epigeon\HttpClient\HeaderInjector
 */
class TimeZoneInjector implements HeaderInjectorInterface {
    private $timezone;

    /**
     * @param string $timezone
     */
    public function __construct(string $timezone)
    {
        $this->timezone = $timezone;
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
        $http_request->headers["X-TIME-ZONE"] = $this->timezone;
    }
}