<?php


namespace Epigeon\HttpClient;

/**
 * Class Curl
 * @package Epigeon\HttpClient
 *
 * Curl wrapper used by HttpClient to make curl requests.
 * @see HttpClientAbstract
 */
class Curl
{
    protected \CurlHandle|false $curl;

    /**
     * Curl constructor.
     * @param $curl
     */
    public function __construct($curl = NULL)
    {
        if (is_null($curl)) {
            $curl = curl_init();
        }
        $this->curl = $curl;
    }

    /**
     * function setOpt
     *
     * @param $option
     * @param $value
     *
     * @return $this
     */
    public function setOpt($option, $value): static
    {
        curl_setopt($this->curl, $option, $value);
        return $this;
    }

    /**
     * function close
     *
     * @return $this
     */
    public function close(): static
    {
        curl_close($this->curl);
        return $this;
    }

    /**
     * function exec
     *
     * @return bool|string
     */
    public function exec(): bool|string
    {
        return curl_exec($this->curl);
    }

    /**
     * function errNo
     *
     * @return int
     */
    public function errNo(): int
    {
        return curl_errno($this->curl);
    }

    /**
     * function getInfo
     *
     * @param $option
     *
     * @return mixed
     */
    public function getInfo($option): mixed
    {
        return curl_getinfo($this->curl, $option);
    }

    /**
     * function error
     *
     * @return string
     */
    public function error(): string
    {
        return curl_error($this->curl);
    }
}
