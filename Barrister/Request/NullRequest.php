<?php

namespace Barrister\Request;

class NullRequest extends AbstractRequest {
    public function __construct() {
        parent::__construct("", array());
    }

    /** @return boolean */
    public function isValid() {
        return true;
    }

    /** @return string */
    public function getInterface() {
        return '';
    }

    /** @return string */
    public function getFunction() {
        return '';
    }


}