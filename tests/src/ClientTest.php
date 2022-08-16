<?php

namespace Memcache\Tests;

use PHPUnit\Framework\TestCase;
use Memcache\Client;

include_once ("vendor/autoload.php");

class ClientTest extends TestCase
{
    public function testConnect()
    {
        // todo :: credentials should be passed from .env
        // from docker container
        $client = new Client('memcached', '11211');

        $key     = "key";
        $message = "Hello world!!!";

        $this->assertNotEmpty($client->set($key, $message));


        $get = $client->get($key);
        $this->assertStringContainsString($get, $message);


        $this->assertNotEmpty($client->delete($key));
    }

}