<?
namespace Barrister\Response;

use Barrister\Response;
use Barrister\Request;

class Ok implements Response {

    /** @var Request */
    private $request;
    private $result;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    public function setResult($result) {
        $this->result = $result;
    }

    public function toString() {
        $resp = array("jsonrpc"=>"2.0", "result"=>$this->result);
        if ($this->request->hasId()) {
            $resp["id"] = $this->request->getId();
        }
        return $resp;
    }

}