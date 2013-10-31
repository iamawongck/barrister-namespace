<?php

namespace Barrister;

use Barrister\BarristerClientInterface;
use Barrister\Exception\BarristerRpcException;

class BarristerClientProxy {
    /**
     * @var \Barrister\BarristerClientInterface
     */
    public $client;
    /**
     * @var string
     */
    public $interfaceName;

    /**
     * @param BarristerClientInterface $client
     * @param string                   $interfaceName
     */
    public function __construct(BarristerClientInterface $client, $interfaceName) {
        $this->client                  = $client;
        $this->interfaceName           = $interfaceName;
    }

    /**
     * @param string $name
     * @param array  $args
     * @return mixed
     * @throws Exception\BarristerRpcException
     */
    public function __call($name, $args) {
        $method = $this->interfaceName . "." . $name;
        $resp   = $this->client->request($method, $args);
        if (isset($resp->error)) {
            throw new BarristerRpcException($resp->error->code,
                                            $resp->error->message,
                                            $resp->error->data);
        }
        else {
            return $resp->result;
        }
    }
}