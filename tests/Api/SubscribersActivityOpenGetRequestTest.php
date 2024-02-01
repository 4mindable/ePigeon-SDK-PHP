<?php

namespace EpigeonTest\Api;

use Epigeon\Api\Environment;
use Epigeon\Api\HttpClient;
use Epigeon\Api\SubscribersActivityOpenGetRequest;
use PHPUnit\Framework\TestCase;

class SubscribersActivityOpenGetRequestTest extends TestCase
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
        $subscribers_activity_request = new SubscribersActivityOpenGetRequest(LIST_KEY, $args);
        $this->assertInstanceOf(SubscribersActivityOpenGetRequest::class, $subscribers_activity_request);
    }

    /**
     * function testExecute
     * @return void
     * @throws \Epigeon\HttpClient\HttpException
     */
    public function testExecute()
    {
        $host = defined('API_HOST')?API_HOST:'api.epigeon.net';
        $environment = new Environment($host,API_KEY, LIST_KEY);
        $args = [
            'date' => date('Y-m-d', strtotime('-1 day')),
            'page_size' => 50,
        ];

        $http_client = new HttpClient($environment);
        $subscribers_activity_request = new SubscribersActivityOpenGetRequest($environment->getList(), $args);
        $subscribers_activity_response = $http_client->execute($subscribers_activity_request);
        $this->assertIsObject($subscribers_activity_response->getResponse());
    }
}