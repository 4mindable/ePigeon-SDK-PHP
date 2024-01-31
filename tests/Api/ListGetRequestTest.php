<?php

namespace EpigeonTest\Api;

use Epigeon\Api\Environment;
use Epigeon\Api\HttpClient;
use Epigeon\Api\ListGetRequest;
use PHPUnit\Framework\TestCase;

class ListGetRequestTest extends TestCase
{
    public function test__construct() {
        if(!defined("API_KEY")){
            $this->fail('API_KEY constant is missing');
        }
        if(!defined("LIST_KEY")){
            $this->fail('LIST_KEY constant is missing');
        }

        $list_request = new ListGetRequest(LIST_KEY);
        $this->assertInstanceOf(ListGetRequest::class, $list_request);
    }

    public function testExecute()
    {
        $environment = new Environment(API_KEY, LIST_KEY);
        $http_client = new HttpClient($environment);
        $list_request = new ListGetRequest($environment->getList());
        $list_response = $http_client->execute($list_request);
        $this->assertIsObject($list_response->getResponse());
    }
}
