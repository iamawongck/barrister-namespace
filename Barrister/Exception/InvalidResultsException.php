<?php

namespace Barrister\Exception;

use Exception;

class InvalidResultsException extends \Exception {
    /**
     * @param string $message
     */
    public function __construct($message) {
        parent::__construct($message, -32001);
    }
}