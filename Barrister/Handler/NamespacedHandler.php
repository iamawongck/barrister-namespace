<?
namespace Barrister\Handler;

use Barrister\Handler;
use Barrister\BarristerContract;
use Barrister\Request;
use Barrister\Exception\RequestException;

class NamespacedHandler implements Handler {

    /** @var BarristerContract */
    private $contract;

    public function __construct(BarristerContract $contract) {
        $this->contract = $contract;
    }

    public function handle(Request $request) {
        if (!$request instanceof \Barrister\NamespacedRequest) {
            throw new RequestException();
        }

        if (!$request->isValid()) {
            $response = $this->errorResponse($request);
        }
        else {
            $response = $this->okResponse($request);
        }
        return $response;
    }

    private function okResponse(Request $request) {
        return new \Barrister\Response\Ok($request);
    }

    private function errorResponse(Request $request) {
        return new \Barrister\Response\Error($request);
    }
}
