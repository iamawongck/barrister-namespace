<?php

namespace Barrister;

use Barrister\Request\AbstractRequest;

interface BarristerTransport {
    /**
     * @param AbstractRequest $request
     * @return mixed
     */
    public function request(AbstractRequest $request);
}