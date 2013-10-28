<?

class Http {
    public function handleHTTP() {
        $isCGI = strpos($_ENV['GATEWAY_INTERFACE'], "CGI") === 0;
        if ($isCGI) {
            $reqJson = file_get_contents('php://stdin', NULL, NULL, 0, $_ENV['CONTENT_LENGTH']);
        }
        else {
            $reqJson = file_get_contents('php://input');
        }

        $resp = null;
        $req  = null;
        try {
            $req = $this->jsonDecoder->decode($reqJson);
        }
        catch (BarristerRpcException $e) {
            $resp = $this->errResp($req, $e->getCode(), $e->getMessage());
        }

        if ($resp === null) {
            $resp = $this->handle($req);
        }

        $respJson = json_encode($resp);
        $len      = strlen($respJson);

        if ($isCGI) {
            print "Content-Type: application/json\r\n";
            print "Content-Length: $len\r\n\r\n";
            print $respJson;
        }
        else {
            header("Content-Type: application/json");
            header("Content-Length: $len");
            print $respJson;
        }
    }
}
