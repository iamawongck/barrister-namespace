<?php

namespace Barrister\Request;

class RequestFactory {
    /**
     * @param string $method
     * @param array  $params
     * @return NamespacedRequest
     */
    public static function makeNamespacedRequest($method, array $params) {
        return new NamespacedRequest($method, $params);
    }
}