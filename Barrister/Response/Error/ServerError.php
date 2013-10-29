<?
namespace Barrister\Response\Error;

use Barrister\Response\Error;
use Barrister\Request;

class ServerError extends Error {

    const MIN_CODE = -32099;
    const MAX_CODE = -32000;

    public function __construct(Request $request) {
        parent::__construct($request);
    }

    public function setCode($code) {
        if ($code < self::MIN_CODE || $code > self::MAX_CODE) {
            throw new \InvalidArgumentException('Invalid Code');
        }
        $this->setCode($code);
    }
}
