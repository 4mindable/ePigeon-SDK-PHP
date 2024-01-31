<?php

namespace Epigeon\Api;

use Epigeon\HttpClient\EnvironmentInterface;

/**
 * Class ApiEnvironment
 * @package Epigeon\API
 */
class Environment implements EnvironmentInterface {
    const API_END_POINT = 'https://api.epigeon.net/v1';
    const API_HEADER_KEY = 'X-API-KEY';
    private $client_key;
    private $list;

    /**
     * @param string $client_key
     * @param string $list
     */
    public function __construct( string $client_key, string $list ) {
        $this->client_key = $client_key;
        $this->list = $list;
    }

    /**
     * function baseUrl
     * @return string
     */
    public function baseUrl(): string {
        return self::API_END_POINT;
    }

    /**
     * function getClientKey
     * @return string
     */
    public function getClientKey() {
        return $this->client_key;
    }

    /**
     * function getList
     * @return string
     */
    public function getList(): string {
        return $this->list;
    }
}