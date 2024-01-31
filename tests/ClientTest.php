<?php

namespace EpigeonTest;

use Epigeon\Client;
use PHPUnit\Framework\TestCase;

/**
 * Class ClientTest
 * @package unit
 * @author Luis M. Bodero
 */
class ClientTest extends TestCase
{
    public function test__construct() {
        if(!defined("API_KEY")){
            $this->fail('Falta definir la constante API_KEY');
        }
        if(!defined("LIST_KEY")){
            $this->fail('Falta definir la constante LIST_KEY');
        }

        $client = new Client(API_KEY, LIST_KEY);
        $this->assertInstanceOf(Client::class, $client);
    }
}
