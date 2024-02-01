<?php


namespace Epigeon\HttpClient;

/**
 * Interface Environment
 * @package Epigeon\HttpClient
 *
 * Describes a domain that hosts a REST API, against which an HttpClient will make requests.
 * @see HttpClientAbstract
 */
interface EnvironmentInterface
{
    public function __construct(string $host, string $client_key, string $list);

    /**
     * @return string
     */
    public function baseUrl(): string;
}
