<?php

namespace memcache;

class Client
{


    private $host;
    private $port;

    public function __construct($host, $port)
    {

        $this->host = $host;
        $this->port = $port;
    }

}