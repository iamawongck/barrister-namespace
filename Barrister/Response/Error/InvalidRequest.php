<?
namespace Barrister\Response\Error;

use Barrister\Response\Error;
use Barrister\Request;

class InvalidRequest extends Error {

    const CODE = -32600;
    const MESSAGE = 'Invalid Request';

    public function __construct(Request $request) {
        parent::__construct($request);
        $this->setCode(self::CODE);
        $this->setMessage(self::MESSAGE);
    }
}
