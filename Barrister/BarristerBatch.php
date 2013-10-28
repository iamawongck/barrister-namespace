<?php

namespace Barrister;

use Barrister\BarristerClient;
use Barrister\BarristerClientProxy;
use Barrister\BarristerClientInterface;

class BarristerBatch implements BarristerClientInterface {
    /**
     * @var BarristerClient
     */
    private $client;

    /**
     * @var array
     */
    private $requests;

    /**
     * @var bool
     */
    private $sent;

    /**
     * @param BarristerClient $client
     */
    public function __construct($client) {
        $this->client   = $client;
        $this->requests = array();
        $this->sent     = false;
    }

    /**
     * @param string $i
     * @return string
     */
    public function getRequest($i) {
        return $this->requests[$i];
    }

    /**
     * @param string $fullyQualifiedNamespace
     * @param string $interfaceName
     * @return BarristerClientProxy
     */
    public function proxy($fullyQualifiedNamespace, $interfaceName) {
        $this->client->contract->checkInterface($interfaceName);
        return new BarristerClientProxy($this, $fullyQualifiedNamespace, $interfaceName);
    }

    /**
     * @param string $method
     * @param array  $params
     * @return mixed|void
     * @throws \Exception
     */
    public function request($method, $params) {
        if ($this->sent) {
            throw new \Exception("Batch has already been sent!");
        }
        array_push($this->requests, $req = $this->client->createRequest($method, $params));
    }

    public function send() {
        if ($this->sent) {
            throw new \Exception("Batch has already been sent!");
        }
        $this->sent = true;

        $results = $this->client->trans->request($this->requests);

        $resultsSorted = array();
        $resultsById   = array();

        foreach ($results as $i => $res) {
            if (isset($res->id)) {
                $resultsById[$res->id] = $res;
            }
        }

        foreach ($this->requests as $i => $req) {
            $res = $resultsById[$req["id"]];
            if (!$res) {
                $err = array("code" => -32603, "message" => "No result for request id: " . $req["id"]);
                $res = array("jsonrpc" => "2.0", "id" => $req["id"], "error" => $err);
            }
            array_push($resultsSorted, $res);
        }

        return $resultsSorted;
    }
}