<?
namespace Barrister\Request;

use Barrister\Request;

abstract class AbstractRequest implements Request {
    const JSON_RPC = "jsonrpc";
    const ID       = "id";
    const METHOD   = "method";
    const PARAMS   = "params";

    private $id;
    private $method;
    private $params;

    public function __construct($method, $params) {
        $this->method = $method;
        $this->params = $params;
    }

    public function getMethod() {
        return $this->method;
    }

    public function getParams() {
        return $this->params;
    }

    public function hasId() {
        return isset($this->id);
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function toJSON() {
        return json_encode(
            array(
                self::JSON_RPC => "2.0",
                self::ID       => $this->hasId() ? $this->getId() : uniqid("", true),
                self::METHOD   => $this->getMethod(),
                self::PARAMS   => $this->getParams()
            ));
    }
}
