<?php

namespace Barrister;

use Barrister\Exception\BarristerRpcException;

class BarristerClientProxy {
    /**
     * @param BarristerClient $client
     * @param string          $interfaceName
     */
    function __construct($client, $interfaceName) {
        $this->client        = $client;
        $this->interfaceName = $interfaceName;
    }

    /**
     * @param $name
     * @param $args
     * @return mixed
     * @throws Exception\BarristerRpcException
     */
    function __call($name, $args) {
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