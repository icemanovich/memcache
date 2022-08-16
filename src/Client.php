<?php

namespace Memcache;


class Client
{

    private const DEFAULT_TTL = 10800;
    private const DEFAULT_PORT = 11211;

    private $host;
    private $port;
    /**
     * @var false|resource|\Socket
     */
    private $socket;

    public function __construct($host, $port = self::DEFAULT_PORT)
    {
        $this->host = $host;
        $this->port = $port;

        $this->connect();
    }

    public function __destruct()
    {
        socket_close($this->socket);
    }


    public function connect()
    {
        try {
            $this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
            $result = socket_connect($this->socket, $this->host, $this->port) or die("Could not connect to server\n");

            if (!$result){
                throw new \Exception("Unable to connect to socket");
            }

            return $this->socket;

        } catch (\Throwable $e){
            // TODO :: Write log to graylog or other place
            throw $e;
        }
    }

    public function sendCommand($command): ?int
    {
        $send = socket_write($this->socket, $command);
        if ($send === false){
            throw new \LogicException("Error on  command 'send'. ... "); // add output to exception
        }
        return $send;
    }


    public function ping(): bool
    {
        $this->sendCommand('stats');
        $out = socket_read($this->socket, '2048');
        return !$out;
    }

    public function version()
    {
        $this->sendCommand('version');
        return socket_read($this->socket, '2048');
    }


    public function get(string $key)
    {
        $command = "get {$key}\r\n";
        $this->sendCommand($command);
        $out = socket_read($this->socket, 2048);
        if ($out){
            $data = [];
            $out = explode("\n", trim($out));
            array_pop($out);
            $out = array_slice($out, 2);

            foreach($out as $line){
                $data[] = trim($line);
            }
            $out = implode(" ", $data);
        }

        return $out;
    }

    public function set(string $key, $value, $ttl = self::DEFAULT_TTL): ?int
    {
        $len = strlen($value);
        $command = "set {$key} 0 {$ttl} {$len}\n{$value}\r\n";
        return $this->sendCommand($command);
    }

    public function delete(string $key)
    {
        $command = "delete {$key}\n";
        return $this->sendCommand($command);
    }

}