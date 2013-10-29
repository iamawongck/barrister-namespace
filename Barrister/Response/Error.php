<?
namespace Barrister\Response;

use Barrister\Response;
use Barrister\Request;

class Error implements Response {

    /** @var Request */
    private $request;
    private $code;
    private $message;
    private $data;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    public function setCode($code) {
        $this->code = $code;
    }

    public function setMessage($message) {
        $this->message = $message;
    }

    public function setData($data) {
        $this->data = $data;
    }

    public function toString() {
        $err = array("code"=>$this->code, "message"=>$this->message);
        if ($this->data) {
            $err["data"] = $this->data;
        }
        $resp = array("jsonrpc"=>"2.0", "error"=>$err);
        if ($this->request->hasId()) {
            $resp["id"] = $this->request->getId();
        }
        return $resp;
    }

}
