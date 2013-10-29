<?
namespace Barrister\Response\Error;

use Barrister\Response\Error;
use Barrister\Request;

class MethodNotFound extends Error {

    const CODE = -32601;
    const MESSAGE = 'Method not found';

    public function __construct(Request $request) {
        parent::__construct($request);
        $this->setCode(self::CODE);
        $this->setMessage(self::MESSAGE);
    }
}
