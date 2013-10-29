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

}