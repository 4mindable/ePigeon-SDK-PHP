<?php

namespace Epigeon\Api;

use Epigeon\HttpClient\HttpRequest;

/**
 * Class SubscriberActivityOpenGetRequest
 * @package Epigeon\Api
 */
class SubscribersActivityOpenGetRequest extends HttpRequest {
    const ARGS_PERMITED = [
        'date',
        'page_size',
        'page_number'
    ];
    const PATH = '/subscribers/activity/open?list={list}';
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