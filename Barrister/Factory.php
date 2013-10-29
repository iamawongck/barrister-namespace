<?
namespace Barrister;

use Barrister\Contract;

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
     * @param $name
     * @param $namespace
     * @return mixed
     */
    static public function makeService(Contract $contract, $name, $namespace) {
        $service = new \stdClass;
        return $service;
    }
}
