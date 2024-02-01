<?php

namespace Epigeon\HttpClient;

/**
 * Interface HeaderInjectorInterface
 * @package Epigeon\HttpClient
 *
 * Interface that can be implemented to apply injectors to Http client.
 *
 * @see HttpClientAbstract
 */
interface HeaderInjectorInterface
{
    /**
     * @param HttpRequest $http_request
     */
    public function inject(HttpRequest $http_request);
}