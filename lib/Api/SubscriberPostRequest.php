<?php

namespace Epigeon\Api;

use Epigeon\HttpClient\HttpRequest;

/**
 * Class SubscriberGetRequest
 * @package Epigeon\Api
 */
class SubscriberPostRequest extends HttpRequest {
    const PATH = '/subscribers';

    /**
     * SubscriberPostRequest constructor.
     */
    public function __construct()
    {
        parent::__construct(self::PATH, "POST");
    }
}