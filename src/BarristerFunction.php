<?php

namespace Barrister;

class BarristerFunction {
    /**
     * @param \stdClass $func
     */
    public function __construct($func) {
        $this->returns = $func->returns;
        $this->params  = $func->params;
    }

    /**
     * @param BarristerContract $contract
     * @param $reqParams
     * @return null|string
     */
    public function validateParams($contract, $reqParams) {
        $len = count($this->params);
        if ($len != count($reqParams)) {
            return "Param length: " . count($reqParams) . " != expected length: $len";
        }

        for ($i = 0; $i < $len; $i++) {
            $p = $this->params[$i];
            $invalid = $contract->validate($p->name, $p, $p->is_array, $reqParams[$i]);
            if ($invalid !== null) {
                return "Invalid request param[$i]: $invalid";
            }
        }

        return null;
    }

    /**
     * @param BarristerContract $contract
     * @param $result
     * @return mixed
     */
    public function validateResult($contract, $result) {
        return $contract->validate("", $this->returns, $this->returns->is_array, $result);
    }
}