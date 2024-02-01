<?php

namespace EpigeonTest\Api;

use Epigeon\Api\Environment;
use Epigeon\Api\HttpClient;
use Epigeon\Api\ListGetRequest;
use PHPUnit\Framework\TestCase;

/**
 * Class ListGetRequestTest
 * @package EpigeonTest\Api
 */
class ListGetRequestTest extends TestCase
{
    /**
     * function test__construct
     * @return void
     */
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

    /**
     * function testExecute
     * @return void
     * @throws \Epigeon\HttpClient\HttpException
     */
    public function testExecute()
    {
        $host = defined('API_HOST')?API_HOST:'api.epigeon.net';
        $environment = new Environment($host, API_KEY, LIST_KEY);
        $http_client = new HttpClient($environment);
        $list_request = new ListGetRequest($environment->getList());
        $list_response = $http_client->execute($list_request);
        $this->assertIsObject($list_response->getResponse());
    }
}
