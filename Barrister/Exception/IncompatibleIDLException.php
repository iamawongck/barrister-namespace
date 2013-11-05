<?php

namespace Barrister\Exception;

class IncompatibleIDLException extends \Exception {
    /**
     * @param string $message
     */
    public function __construct($message) {
        parent::__construct($message, -32601);
    }
}