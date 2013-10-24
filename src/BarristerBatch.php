<?php

namespace Barrister;

class BarristerBatch {
    /**
     * @var BarristerClient
     */
    private $client;

    /**
     * @param BarristerClient $client
     */
    function __construct($client) {
        $this->client = $client;
        $this->requests = array();
        $this->sent = false;
    }

    function getRequest($i) {
        return $this->requests[$i];
    }

    function proxy($interfaceName) {
        $this->client->contract->checkInterface($interfaceName);
        return new BarristerClientProxy($this, $interfaceName);
    }

    function request($method, $params) {
        if ($this->sent) {
            throw new \Exception("Batch has already been sent!");
        }
        array_push($this->requests, $req = $this->client->createRequest($method, $params));
    }

    function send() {
        if ($this->sent) {
            throw new \Exception("Batch has already been sent!");
        }
        $this->sent = true;

        $results = $this->client->trans->request($this->requests);

        $resultsSorted = array();
        $resultsById   = array();

        foreach ($results as $i=>$res) {
            if (isset($res->id)) {
                $resultsById[$res->id] = $res;
            }
        }

        foreach ($this->requests as $i=>$req) {
            $res = $resultsById[$req["id"]];
            if (!$res) {
                $err = array("code"=>-32603, "message"=>"No result for request id: " . $req["id"]);
                $res = array("jsonrpc"=>"2.0", "id"=>$req["id"], "error"=>$err);
            }
            array_push($resultsSorted, $res);
        }

        return $resultsSorted;
    }
}