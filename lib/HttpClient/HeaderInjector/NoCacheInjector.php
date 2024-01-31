<?php
/*
 * Blogs Herder Editorial
 * (C) 2023 - Herder Editorial SL, Barcelona
 *
 * @author: Luis M. Bodero
 * Date: 2023-5-3
 */

namespace Epigeon\HttpClient\HeaderInjector;

use Epigeon\HttpClient\HeaderInjectorInterface;
use Epigeon\HttpClient\HttpRequest;

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