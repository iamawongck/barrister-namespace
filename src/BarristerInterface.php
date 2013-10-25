<?php

namespace Barrister;

class BarristerInterface {
    /**
     * @var BarristerFunction[]
     */
    private $functions;

    /**
     * @param \stdClass $iface json_decoded object
     */
    public function __construct($iface) {
        $this->functions = array();
        foreach ($iface->functions as $i => $func) {
            $this->functions[$func->name] = new BarristerFunction($func);
        }
    }

    /**
     * @param string $name
     * @return BarristerFunction
     */
    public function getFunction($name) {
        return $this->functions[$name];
    }
}