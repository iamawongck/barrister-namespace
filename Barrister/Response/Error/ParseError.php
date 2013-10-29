<?
namespace Barrister\Response\Error;

use Barrister\Response\Error;
use Barrister\Request;

class ParseError extends Error {

    const CODE = -32700;
    const MESSAGE = 'Parse error';

    public function __construct(Request $request) {
        parent::__construct($request);
        $this->setCode(self::CODE);
        $this->setMessage(self::MESSAGE);
    }
}
