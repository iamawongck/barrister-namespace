<?
namespace Barrister\Request;

use Barrister\Request\AbstractRequest;

class NamespacedRequest extends AbstractRequest {

    const FULLY_QUALIFIED_NAMESPACE = "namespace_name";
    const INTERFACE_NAME            = "interface_name";
    const FUNCTION_NAME             = "function_name";

    private $namespace;
    private $interface;
    private $function;

    public function __construct($method, $params) {
        parent::__construct($method, $params);
        $this->initMethod();
    }

    public function isValid() {
        return $this->hasNamespace() && $this->hasInterface() && $this->hasFunction();
    }

    public function getFunction() {
        return $this->function;
    }

    public function getInterface() {
        return $this->interface;
    }

    public function getNamespace() {
        return $this->namespace;
    }

    private function initMethod() {
        $method = $this->getMethod();
        $pos = strpos($method, '.');

        if ($pos > 0) {
            $this->namespace = substr($method, 0, $pos);
            $method = substr($method, $pos + 1);

            $pos = strpos($method, '.');

            if ($pos > 0) {
                $this->interface = substr($method, 0, $pos);
                $this->function = substr($method, $pos + 1);
            }
        }
    }

    private function hasNamespace() {
        return isset($this->namespace);
    }

    private function hasInterface() {
        return isset($this->interface);
    }

    private function hasFunction() {
        return isset($this->function);
    }
}
