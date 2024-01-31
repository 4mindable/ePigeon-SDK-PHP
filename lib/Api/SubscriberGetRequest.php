<?php

namespace Epigeon\Api;

use Epigeon\HttpClient\HttpRequest;

/**
 * Class SubscriberGetRequest
 * @package Epigeon\Api
 */
class SubscriberGetRequest extends HttpRequest {
    const PATH = '/subscribers/{email}?list={list}';
    public function __construct(string $email, string $list)
    {
        $path = str_replace(['{email}', '{list}'], [urlencode($email), urlencode($list)], self::PATH);
        parent::__construct($path, "GET");
    }
}