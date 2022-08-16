<?php

namespace memcache;

class Client
{

    private const DEFAULT_TTL = 10800;

    private $host;
    private $port;

    public function __construct($host, $port)
    {
        $this->host = $host;
        $this->port = $port;

        $this->connect();
    }


    public function connect()
    {
        $request = new \GuzzleHttp\Psr7\Request('GET', 'http://httpbin.org');
    }


    public function ping(): bool
    {
        return true;
    }


    public function get(string $key)
    {

    }

    public function set(string $key, $value, $ttl = self::DEFAULT_TTL)
    {
        return 1;
    }

    public function delete(string $key): ?int
    {
        return 1;
    }


    private function exec()
    {

    }



}