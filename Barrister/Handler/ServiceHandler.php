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
        $this->validateRequest($request);

        $paramObjects = $this->makeParams($request->getParams());

        $result = $this->callFunction($request->getFunction(), $paramObjects);

        $this->validateResult($result);

        return $this->makeSuccessResponse($result);
    }

    private function okResponse(Request $request) {
        return new Ok($request);
    }

    private function errorResponse(Request $request) {
        return new Error($request);
    }

    /**
     * @param Request\AbstractRequest $request
     * @throws \Barrister\Exception\RequestException
     */
    private function validateRequest(Request\AbstractRequest $request) {
        if (!$this->contract->validateInterface($request->getInterface())) {
            throw new RequestException("Request does fulfill the contract's interface name");
        }

        foreach ($request->getParams() as $param) {
            if (!$this->contract->validateStruct($param->type)) {
                throw new RequestException("Request does fulfill the contract's struct name");
            }
        }
    }


    private function makeParams(array $params) {

    }

    private function callFunction($function, $functionArgumentObjects) {

    }

    private function validateResult($result) {

    }

    private function makeSuccessResponse($result) {

    }
}
