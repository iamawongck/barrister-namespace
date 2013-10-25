<?php

namespace Barrister\Exception;

class BarristerRpcException extends \Exception {
    /**
     * @var null
     */
    private $data;

    /**
     * @param string $code
     * @param int    $message
     * @param null   $data
     */
    public function __construct($code, $message, $data=null) {
        parent::__construct($message, $code);
        $this->data = $data;
    }

    /**
     * @return null
     */
    public function getData() {
        return $this->data;
    }

    /**
     * @return string
     */
    public function __toString() {
        $s = "BarristerRpcException code=" . $this->getCode() . " message=" . $this->getMessage();
        if (isset($this->data)) {
            $s .= " data=" . $this->data;
        }
        return $s;
    }
}