<?php

namespace Epigeon\Api;

use Epigeon\HttpClient\HttpRequest;

/**
 * Class SubscriberDeleteRequest
 * @package Epigeon\Api
 */
class SubscriberDeleteRequest extends HttpRequest {
    const PATH = '/subscribers/{email}?list={list}';

    /**
     * SubscriberDeleteRequest constructor.
     * @param string $email
     * @param string $list
     */
    public function __construct(string $email, string $list)
    {
        $path = str_replace(['{email}', '{list}'], [urlencode($email), urlencode($list)], self::PATH);
        parent::__construct($path, "DELETE");
    }
}