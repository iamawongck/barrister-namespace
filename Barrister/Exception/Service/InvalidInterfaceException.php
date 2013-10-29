<?
namespace Barrister\Exception\Service;

class InvalidInterfaceException extends \Exception {

    const MESSAGE = 'Could not find the requested interface in the Contract';

    public function __construct($name, $message = self::MESSAGE) {
        parent::__construct($message . ": $name");
    }
}
