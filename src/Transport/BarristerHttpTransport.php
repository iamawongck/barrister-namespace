<?php

namespace Barrister\Transport;

use Barrister\BarristerTransport;
use Barrister\Exception\BarristerRpcException;

class BarristerHttpTransport implements BarristerTransport {
    /**
     * @param string $url
     */
    public function __construct($url) {
        $this->url = $url;
    }

    /**
     * @param $req
     * @return mixed
     * @throws \Barrister\Exception\BarristerRpcException
     */
    public function request($req) {
        $post_data = json_encode($req);
        //print "request: $post_data\n";
        $headers = array('Content-Type: application/json', 'Content-Length: ' . strlen($post_data));
        $ch      = curl_init($this->url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        if ($result === false) {
            $err = curl_error($ch);
            throw new BarristerRpcException(-32603, "HTTP POST to " . $this->url . " failed: " . $err);
        }
        else {
            //print "result: $result\n";
            $resp = $this->bar_json_decode($result);
            return $resp;
        }
    }

    private function bar_json_decode($jsonStr) {
        if ($jsonStr === null || $jsonStr === "null") {
            return null;
        }

        $ok  = true;
        $val = json_decode($jsonStr);
        if (function_exists('json_last_error')) {
            if (json_last_error() !== JSON_ERROR_NONE) {
                $ok = false;
            }
        }
        else if ($val === null) {
            $ok = false;
        }

        if ($ok) {
            return $val;
        }
        else {
            $s = substr($jsonStr, 0, 100);
            throw new BarristerRpcException(-32700, "Unable to decode JSON. First 100 chars: $s");
        }
    }
}