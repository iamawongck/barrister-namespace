<?php

namespace Barrister\Request;

interface KeyedRequest {
    /**
     * @return string
     */
    public function getKey();
}