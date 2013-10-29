<?
namespace Barrister;

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
     * @param BarristerContract $contract
     * @param $name
     * @param $namespace
     * @return mixed
     */
    static public function makeService(BarristerContract $contract, $name, $namespace) {
        $service = new \stdClass;
        return $service;
    }
}
