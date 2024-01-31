<?php

namespace Epigeon\Api;

use Epigeon\HttpClient\HttpRequest;

class ListGetRequest extends HttpRequest {
    const PATH = '/lists/{list}';

    /**
     * @param string $list
     */
    public function __construct( string $list ) {
        $path = str_replace( '{list}', urlencode( $list ), self::PATH );
        parent::__construct( $path, "GET" );
    }
}