<?php

namespace EpigeonTest\Api;

use Epigeon\Api\Environment;
use Epigeon\Api\HttpClient;
use Epigeon\Api\SubscriberGetRequest;
use PHPUnit\Framework\TestCase;

/**
 * Class SubscriberGetRequestTest
 * @package EpigeonTest\Api
 */
class SubscriberGetRequestTest extends TestCase
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

        $subscriber_request = new SubscriberGetRequest(SUBSCRIBER_EMAIL, LIST_KEY);
        $this->assertInstanceOf(SubscriberGetRequest::class, $subscriber_request);
    }

    /**
     * function testBadEmailExecute
     * @return void
     * @throws \Epigeon\HttpClient\HttpException
     */
    public function testBadEmailExecute()
    {
        $this->expectExceptionMessageMatches('/.*Is not a valid email.*/');
        $host = defined('API_HOST')?API_HOST:'api.epigeon.net';
        $environment = new Environment($host, API_KEY, LIST_KEY);
        $http_client = new HttpClient($environment);
        $subscriber_request = new SubscriberGetRequest('bad-email', $environment->getList());
        $subscriber_response = $http_client->execute($subscriber_request);
    }

    /**
     * function testBadSubscriberExecute
     * @return void
     * @throws \Epigeon\HttpClient\HttpException
     */
    public function testBadSubscriberExecute()
    {
        $this->expectExceptionMessageMatches('/.*Not found.*/');
        $host = defined('API_HOST')?API_HOST:'api.epigeon.net';
        $environment = new Environment($host,API_KEY, LIST_KEY);
        $http_client = new HttpClient($environment);
        $subscriber_request = new SubscriberGetRequest('bad@epigeon.net', $environment->getList());
        $subscriber_response = $http_client->execute($subscriber_request);
    }

    /**
     * function testExecute
     * @return void
     * @throws \Epigeon\HttpClient\HttpException
     */
    public function testExecute()
    {
        if(!defined("SUBSCRIBER_EMAIL")){
            $this->fail('SUBSCRIBER_EMAIL constant is missing');
        }

        $host = defined('API_HOST')?API_HOST:'api.epigeon.net';
        $environment = new Environment($host,API_KEY, LIST_KEY);

        $http_client = new HttpClient($environment);
        $subscriber_request = new SubscriberGetRequest(SUBSCRIBER_EMAIL, $environment->getList());
        $subscriber_response = $http_client->execute($subscriber_request);
        $this->assertIsObject($subscriber_response->getResponse());
    }
}