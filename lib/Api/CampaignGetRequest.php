<?php

namespace Epigeon\Api;

use Epigeon\HttpClient\HttpRequest;

/**
 * Class CampaignGetRequest
 * @package Epigeon\Api
 */
class CampaignGetRequest extends HttpRequest
{
    const PATH = '/campaigns/{campaign_id}?list={list}';

    /**
     * CampaignGetRequest constructor.
     * @param int $campaign_id
     * @param string $list
     */
    public function __construct(int $campaign_id, string $list)
    {
        $path = str_replace(['{campaign_id}', '{list}'], [$campaign_id, urlencode($list)], self::PATH);
        parent::__construct($path, "GET");
    }
}