<?php


namespace Epigeon\HttpClient\HeaderInjector;

use Epigeon\HttpClient\HeaderInjectorInterface;
use Epigeon\HttpClient\HttpRequest;

/**
 * Class UserAgentInjector
 * @package Epigeon\HttpClient\HeaderInjector
 */
class UserAgentInjector implements HeaderInjectorInterface
{
    const DEFAULT_USER_AGENT = 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:109.0) Gecko/20100101 Firefox/112.0';

    private string $user_agent;

    /**
     * UserAgentInjector constructor
     *
     * @param string|null $user_agent
     */
    public function __construct(?string $user_agent = null)
    {
        $this->user_agent = $user_agent??self::DEFAULT_USER_AGENT;
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
        $http_request->headers["User-Agent"] = $this->user_agent;
    }
}