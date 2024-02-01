<?php

namespace EpigeonTest\Api;

use Epigeon\Api\Environment;
use Epigeon\Api\HttpClient;
use Epigeon\Api\SubscribersActivityClickGetRequest;
use PHPUnit\Framework\TestCase;

class SubscribersActivityClickGetRequestTest extends TestCase
{
    /**
     * function test__construct
     * @return void
     */
    public function test__construct()
    {
        if(!defined("API_KEY")){
            $this->fail('API_KEY constant is missing');
        }
        if(!defined("LIST_KEY")){
            $this->fail('LIST_KEY constant is missing');
        }

        $args = [
            'date' => date('Y-m-d', strtotime('-1 day')),
            'page_size' => 50,
        ];
        $subscribers_activity_request = new SubscribersActivityClickGetRequest(LIST_KEY, $args);
        $this->assertInstanceOf(SubscribersActivityClickGetRequest::class, $subscribers_activity_request);
    }

    public function textExecute()
    {
        $host = defined('API_HOST')?API_HOST:'api.epigeon.net';
        $environment = new Environment($host,API_KEY, LIST_KEY);
        $args = [
            'date' => date('Y-m-d', strtotime('-1 day')),
            'page_size' => 50,
        ];

        $http_client = new HttpClient($environment);
        $subscribers_activity_request = new SubscribersActivityClickGetRequest($environment->getList(), $args);
        $subscribers_activity_response = $http_client->execute($subscribers_activity_request);
        $this->assertIsObject($subscribers_activity_response->getResponse());
    }
}
