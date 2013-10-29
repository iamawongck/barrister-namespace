<?
namespace Barrister;

use Barrister\Contract;
use Barrister\Service;
use Barrister\Service\NullService;
use Barrister\Exception\Service\InvalidInterfaceException;

class Factory {

    /**
     * @param $idlFile
     * @return Contract
     */
    static public function makeContract($idlFile) {
        $jsonDecoder = new BarristerJsonDecoder();
        $contract = new Contract($idlFile, $jsonDecoder);
        return $contract;
    }

    /**
     * @param Contract $contract
     * @param string $name
     * @param string $namespace
     * @throws InvalidInterfaceException
     * @return Service
     */
    static public function makeService(Contract $contract, $name, $namespace) {
        $service = new NullService();

        try {
            $interface = $contract->getInterface($name);
        } catch (InvalidInterfaceException $e) {
            throw $e;
        }



        return $service;
    }
}