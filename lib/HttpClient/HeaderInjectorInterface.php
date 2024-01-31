<?php
/*
 * Blogs Herder Editorial
 * (C) 2023 - Herder Editorial SL, Barcelona
 *
 * @author: Luis M. Bodero
 * Date: 2023-5-2
 */

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