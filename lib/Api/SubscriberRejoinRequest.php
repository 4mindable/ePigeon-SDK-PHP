<?php

namespace Epigeon\Api;

use Epigeon\HttpClient\HttpRequest;

/**
 * Class SubscriberRejoinRequest
 * @package Epigeon\Api
 */
class SubscriberRejoinRequest extends HttpRequest {
    const PATH = '/subscribers/rejoin/{email}?list={list}';

    /**
     * SubscriberRejoinRequest constructor.
     * @param string $email
     * @param string $list
     */
    public function __construct(string $email, string $list)
    {
        $path = str_replace(['{email}', '{list}'], [urlencode($email), urlencode($list)], self::PATH);
        parent::__construct($path, "PATCH");
    }
}