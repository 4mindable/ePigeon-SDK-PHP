<?php
/*
 * Blogs Herder Editorial
 * (C) 2022 - Herder Editorial SL, Barcelona
 *
 * @author: Luis M. Bodero
 * Date: 2022-7-22
 */

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
    public function __construct(string $client_key, string $list);

    /**
     * @return string
     */
    public function baseUrl(): string;
}
