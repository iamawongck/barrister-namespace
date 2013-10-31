<?php

namespace Barrister;

use Barrister\BarristerClientProxy;
use Barrister\BarristerContract;
use Barrister\BarristerTransport;
use Barrister\BarristerBatch;
use Barrister\BarristerClientInterface;

class BarristerClient implements BarristerClientInterface {
    /**
     * @var BarristerTransport
     */
    public $trans;

    /**
     * @var BarristerContract
     */
    public $contract;

    /**
     * @param BarristerTransport $trans
     * @param BarristerContract  $contract
     */
    public function __construct(BarristerTransport $trans, BarristerContract $contract) {
        $this->trans = $trans;
        $this->contract = $contract;
    }

    /**
     * @param string $interfaceName
     * @return BarristerClientProxy
     */
    public function proxy($interfaceName) {
        $this->contract->checkInterface($interfaceName);
        return new BarristerClientProxy($this, $interfaceName);
    }

    /**
     * @return array
     */
    public function getMeta() {
        return $this->contract->getMeta();
    }

    /**
     * @return BarristerBatch
     */
    public function startBatch() {
        return new BarristerBatch($this);
    }

    /**
     * @param string $method
     * @param array  $params
     * @return mixed
     */
    public function request($method, $params) {
        $req = $this->createRequest($method, $params);
        return $this->trans->request($req);
    }

    /**
     * @param string $method
     * @param array  $params
     * @return array
     */
    public function createRequest($method, $params) {
        $req = array("jsonrpc" => "2.0", "id" => uniqid("", true), "method" => $method);
        if ($params && is_array($params) && count($params) > 0) {
            $req["params"] = $params;
        }
        return $req;
    }
}