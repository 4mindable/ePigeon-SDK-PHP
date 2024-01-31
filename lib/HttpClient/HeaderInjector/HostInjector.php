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