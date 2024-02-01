<?php

namespace Epigeon\Api;

use Epigeon\HttpClient\EnvironmentInterface;

/**
 * Class ApiEnvironment
 * @package Epigeon\API
 */
class Environment implements EnvironmentInterface {
    const API_VERSION = 'v1';
    private string $host;
    private string $client_key;
    private string $list;

    /**
     * Environment constructor.
     * @param string $host
     * @param string $client_key
     * @param string $list
     */
    public function __construct(string $host, string $client_key, string $list )
    {
        $this->host = $host;
        $this->client_key = $client_key;
        $this->list = $list;
    }

    /**
     * function baseUrl
     * @return string
     */
    public function baseUrl(): string
    {
        return 'https://'.$this->host.'/'.self::API_VERSION;
    }

    /**
     * function getClientKey
     * @return string
     */
    public function getClientKey(): string
    {
        return $this->client_key;
    }

    /**
     * function getList
     * @return string
     */
    public function getList(): string
    {
        return $this->list;
    }
}