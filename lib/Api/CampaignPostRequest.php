<?php

namespace Epigeon\Api;

use Epigeon\HttpClient\HttpRequest;

/**
 * Class CampaignGetRequest
 * @package Epigeon\Api
 */
class CampaignPostRequest extends HttpRequest
{
    const PATH = '/campaigns';

    /**
     * CampaignPostRequest constructor.
     */
    public function __construct()
    {
        parent::__construct(self::PATH, "POST");
    }
}