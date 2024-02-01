<?php

namespace EpigeonTest\Api;

use Epigeon\Api\CampaignGetRequest;
use PHPUnit\Framework\TestCase;

/**
 * Class CampaignGetRequestTest
 * @package EpigeonTest\Api
 */
class CampaignGetRequestTest extends TestCase
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

        $campaign_request = new CampaignGetRequest(1, LIST_KEY);
        $this->assertInstanceOf(CampaignGetRequest::class, $campaign_request);
    }
}
