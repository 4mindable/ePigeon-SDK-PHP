<?php

namespace Epigeon;

use Epigeon\Api\CampaignGetRequest;
use Epigeon\Api\CampaignPostRequest;
use Epigeon\Api\Environment;
use Epigeon\Api\HttpClient;
use Epigeon\Api\ListGetRequest;
use Epigeon\Api\SubscriberGetRequest;
use Epigeon\Api\SubscribersActivityClickGetRequest;
use Epigeon\Api\SubscribersActivityOpenGetRequest;
use Epigeon\HttpClient\HttpException;

/**
 * Class Client
 * @package Epigeon\Api
 */
class Client {
    const DEFAULT_TIMEZONE = 'Europe/Madrid';
    private Environment $environment;

    private HttpClient $http_client;

    /**
     * @param string $client_key
     * @param string $list
     */
    public function __construct(string $client_key, string $list){
        $this->environment = new Environment($client_key, $list);
        $this->http_client = new HttpClient($this->environment);
    }

    /**
     * function setTimezone
     *
     * @param string $timezone
     *
     * @return void
     */
    public function setTimezone(string $timezone):void
    {
        $this->http_client->setTimezone($timezone);
    }

    /**
     * function getCampaign
     *
     * @param int $campaign_id
     *
     * @return array|object|string
     * @throws HttpException
     */
    public function getCampaign(int $campaign_id): object|array|string
    {
        $campaign_request = new CampaignGetRequest($campaign_id, $this->environment->getList());
        $campaign_response = $this->http_client->execute($campaign_request);
        return $campaign_response->getResponse();
    }

    /**
     * function postCampaign
     *
     * @param array $arguments
     *
     * @return array|object|string
     * @throws HttpException
     */
    public function postCampaign(array $arguments) {
        $arguments['list'] = $this->environment->getList();
        $campaign_request = new CampaignPostRequest();
        $campaign_request->setBody($arguments);
        $campaign_response = $this->http_client->execute($campaign_request);
        return $campaign_response->getResponse();
    }

    /**
     * function getSubscriber
     *
     * @param string $email
     *
     * @return array|object|string
     * @throws HttpException
     */
    public function getSubscriber(string $email) {
        $subscriber_request = new SubscriberGetRequest($email, $this->environment->getList());
        $subscriber_response = $this->http_client->execute($subscriber_request);
        return $subscriber_response->getResponse();
    }

    /**
     * function getList
     * @return array|object|string
     * @throws HttpException
     */
    public function getList(): object|array|string
    {
        $list_request = new ListGetRequest($this->environment->getList());
        $subscriber_response = $this->http_client->execute($list_request);
        return $subscriber_response->getResponse();
    }

    /**
     * function getSubscribersActivity
     *
     * @param string $type
     * @param array $args
     *
     * @return array|object|string
     * @throws HttpException
     */
    public function getSubscribersActivity(string $type, array $args) {
        $subscriber_activity = match ($type) {
            'open' => new SubscribersActivityOpenGetRequest($this->environment->getList(), $args),
            'click' => new SubscribersActivityClickGetRequest($this->environment->getList(), $args),
            default => throw new HttpException('El tipo especificado no existe.', 404),
        };
        $subscriber_response = $this->http_client->execute($subscriber_activity);

        return $subscriber_response->getResponse();
    }
}