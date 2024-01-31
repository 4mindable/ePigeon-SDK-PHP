<?php

namespace Epigeon\Api;

use Epigeon\HttpClient\HeaderInjector\ApiKeyInjector;
use Epigeon\HttpClient\HeaderInjector\ContentTypeJsonInjector;
use Epigeon\HttpClient\HeaderInjector\FetchInjector;
use Epigeon\HttpClient\HeaderInjector\GzipInjector;
use Epigeon\HttpClient\HeaderInjector\HostInjector;
use Epigeon\HttpClient\HeaderInjector\NoCacheInjector;
use Epigeon\HttpClient\HeaderInjector\TimeZoneInjector;
use Epigeon\HttpClient\HeaderInjector\UserAgentInjector;
use Epigeon\HttpClient\HttpClientAbstract;

/**
 * Class HttpClient
 * @package Epigeon\API
 */
class HttpClient extends HttpClientAbstract {

    /**
     * @param Environment $environment
     */
    public function __construct( Environment $environment ) {
        parent::__construct( $environment );
        $parse_url = parse_url( $environment->baseUrl() );

        $this->addInjector( new ApiKeyInjector( $environment->getClientKey() ) );
        $this->addInjector( new HostInjector( $parse_url['host'] ) );
        $this->addInjector( new GzipInjector() );
        $this->addInjector( new UserAgentInjector() );
        $this->addInjector( new NoCacheInjector() );
        $this->addInjector( new FetchInjector() );
        $this->addInjector( new ContentTypeJsonInjector() );
    }

    /**
     * function setTimezone
     *
     * @param string $timezone
     *
     * @return void
     */
    public function setTimezone(string $timezone):void
    {
        $this->addInjector( new TimeZoneInjector( $timezone ) );
    }
}