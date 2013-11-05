<?php

namespace Barrister\Exception;

use Exception;

class IncompleteRequestException extends \Exception {
    const NO_METHOD = "No method specified on request";

    /**
     * @param string $message
     */
    public function __construct($message = self::NO_METHOD) {
        parent::__construct($message, -32600);
    }
}