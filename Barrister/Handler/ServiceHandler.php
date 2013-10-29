<?
namespace Barrister\Handler;

use Barrister\Contract;
use Barrister\Exception\RequestException;
use Barrister\Handler;
use Barrister\Request;
use Barrister\Request\NamespacedRequest;
use Barrister\Response\Error;
use Barrister\Response\Ok;
use Barrister\Service;

class ServiceHandler implements Handler {
    /**
     * @var \Barrister\Contract
     */
    private $contract;
    /**
     * @var \Barrister\Service
     */
    private $service;

    /**
     * @param Contract $contract
     * @param Service  $service
     */
    public function __construct(Contract $contract, Service $service) {
        $this->contract = $contract;
        $this->service  = $service;
    }

    /**
     * @param Request\AbstractRequest $request
     * @return Error|Ok|mixed
     * @throws \Barrister\Exception\RequestException
     */
    public function handle(Request\AbstractRequest $request) {
        if (!$this->validateRequest($request)) {
            $this->errorResponse($request);
        }


        if (!$request instanceof NamespacedRequest) {
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
        return new Ok($request);
    }

    private function errorResponse(Request $request) {
        return new Error($request);
    }

    /**
     * @param Request $request
     * @return bool
     */
    private function validateRequest(Request $request) {
        $this->contract->validateInterface($request->getInterface());
    }
}
