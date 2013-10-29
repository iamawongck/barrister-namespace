<?php

namespace Barrister\Server;

use Barrister\Request;
use Barrister\Server;

class NamespacedServer extends Server {
    /**
     * @param \stdClass $json
     * @return Request
     */
    protected function makeRequestFromJSON($json) {
        return new Request\NamespacedRequest($json->method, $json->params);
    }
}