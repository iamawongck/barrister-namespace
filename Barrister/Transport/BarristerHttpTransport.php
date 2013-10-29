<?php

namespace Barrister\Transport;

use Barrister\BarristerJsonDecoder;
use Barrister\BarristerTransport;
use Barrister\Exception\BarristerRpcException;
use Barrister\Request\AbstractRequest;

class BarristerHttpTransport implements BarristerTransport {
    /**
     * @var
     */
    public $url;

    /**
     * @var \Barrister\BarristerJsonDecoder
     */
    public $jsonDecoder;

    /**
     * @param                      $url
     * @param BarristerJsonDecoder $jsonDecoder
     */
    public function __construct($url, BarristerJsonDecoder $jsonDecoder) {
        $this->url = $url;
        $this->jsonDecoder = $jsonDecoder;
    }

    /**
     * @param AbstractRequest $request
     * @return mixed|null
     * @throws \Barrister\Exception\BarristerRpcException
     */
    public function request(AbstractRequest $request) {
        $post_data = $request->toJSON();
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
            $resp = $this->jsonDecoder->decode($result);
            return $resp;
        }
    }
}