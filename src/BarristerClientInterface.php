<?php

namespace Barrister;

interface BarristerClientInterface {
    /**
     * @param string $method
     * @param array  $params
     * @return mixed
     */
    public function request($method, $params);
}