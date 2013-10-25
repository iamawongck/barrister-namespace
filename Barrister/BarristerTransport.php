<?php

namespace Barrister;

interface BarristerTransport {
    public function request($req);
}