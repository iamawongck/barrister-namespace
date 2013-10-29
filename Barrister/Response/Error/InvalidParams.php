<?
namespace Barrister\Response\Error;

use Barrister\Response\Error;
use Barrister\Request;

class InvalidParams extends Error {

    const CODE = -32602;
    const MESSAGE = 'Invalid Request';

    public function __construct(Request $request) {
        parent::__construct($request);
        $this->setCode(self::CODE);
        $this->setMessage(self::MESSAGE);
    }
}
