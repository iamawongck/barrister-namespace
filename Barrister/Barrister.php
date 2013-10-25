<?php

namespace Barrister;

use Barrister\BarristerClient;
use Barrister\Transport\BarristerHttpTransport;

class Barrister {
    /**
     * @param string $url
     * @return BarristerClient
     */
    public function httpClient($url) {
        return new BarristerClient(new BarristerHttpTransport($url, new BarristerJsonDecoder()));
    }
}