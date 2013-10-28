<?
namespace Barrister\Request;

use Barrister\Request;

abstract class AbstractRequest implements Request {

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

    public function setId($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }
}
