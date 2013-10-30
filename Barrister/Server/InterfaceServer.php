<?php

namespace Barrister\Server;

use Barrister\Request;
use Barrister\Server;

class InterfaceServer extends Server {
    /**
     * @param \stdClass $json
     * @return Request
     */
    protected function makeRequestFromJSON($json) {
        return new Request\InterfaceRequest($json->method, $json->params);
    }
}