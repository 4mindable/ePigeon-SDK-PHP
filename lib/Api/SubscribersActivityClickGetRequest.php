<?php

namespace Epigeon\Api;

use Epigeon\HttpClient\HttpRequest;

/**
 * Class SubscribersActivityClickGetRequest
 * @package Epigeon\Api
 */
class SubscribersActivityClickGetRequest extends HttpRequest
{
    const ARGS_PERMITED = [
        'date',
        'page_size',
        'page_number'
    ];
    const PATH = '/subscribers/activity/click?list={list}&page_size=50';

    /**
     * SubscribersActivityClickGetRequest constructor.
     * @param string $list
     * @param array $args
     */
    public function __construct(string $list, array $args)
    {
        $path = str_replace( '{list}', urlencode( $list ), self::PATH );
        foreach ($args AS $key=>$value){
            if(in_array($key, self::ARGS_PERMITED)){
                $path .= "&{$key}={$value}";
            }
        }
        parent::__construct($path, "GET");
    }
}