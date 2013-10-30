<?php

namespace Barrister\Request;

class InterfaceRequest extends AbstractRequest implements KeyedRequest {
    const INTERFACE_NAME = "interface_name";
    const FUNCTION_NAME  = "function_name";
    /**
     * @var string
     */
    private $interface;

    /**
     * @var string
     */
    private $function;

    /**
     * @param string $method
     * @param array  $params
     */
    public function __construct($method, array $params) {
        parent::__construct($method, $params);
        $this->initMethod();
    }

    /**
     * @return bool
     */
    public function isValid() {
        return $this->hasInterface() && $this->hasFunction();
    }

    /**
     * @return string
     */
    public function getFunction() {
        return $this->function;
    }

    /**
     * @return string
     */
    public function getInterface() {
        return $this->interface;
    }

    /**
     * @return string
     */
    public function getKey() {
        return $this->getInterface();
    }

    private function initMethod() {
        $method = $this->getMethod();

        $pos = strpos($method, '.');

        if ($pos > 0) {
            $this->interface = substr($method, 0, $pos);
            $this->function  = substr($method, $pos + 1);
        }
    }

    /**
     * @return bool
     */
    private function hasInterface() {
        return isset($this->interface);
    }

    /**
     * @return bool
     */
    private function hasFunction() {
        return isset($this->function);
    }
}
