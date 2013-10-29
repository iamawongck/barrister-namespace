<?
use org\bovigo\vfs\vfsStream;

class FactoryTest extends PHPUnit_Framework_TestCase {

    const DIR = 'root';
    const FILENAME = 'myIdlFile.json';
    const IDL_JSON = '[{"comment": "", "extends": "", "type": "struct", "name": "Entry", "fields": [{"comment": "", "optional": true, "is_array": false, "type": "int", "name": "id"}]},
    {"comment": "", "functions": [{"comment": "", "returns": {"optional": false, "is_array": false, "type": "bool"}, "params": [{"is_array": false, "type": "Entry", "name": "reportRaw"}], "name": "insert"}], "type": "interface", "name": "Service"},
    {"barrister_version": "0.1.5", "type": "meta", "date_generated": 1382473134463, "checksum": "f47b85c0b3b9ce5ce3d758d854597173"}]';

    const INVALID_JSON = 'a[]';

    public function testMakeContract() {
        $contract = $this->getContract(self::IDL_JSON);
        $this->assertInstanceOf('\Barrister\Contract', $contract);
    }

    /**
     * @expectedException \Barrister\Exception\BarristerRpcException
     */
    public function testBadJson() {
        $this->getContract(self::INVALID_JSON);
    }

    public function getContract($jsonContent) {
        $root = vfsStream::setup(self::DIR);
        $idlFile = vfsStream::newFile(self::FILENAME);
        $idlFile->setContent($jsonContent);
        $root->addChild($idlFile);

        $this->assertTrue($root->hasChild(self::FILENAME));

        $jsonDecoder = new \Barrister\BarristerJsonDecoder();

        return new \Barrister\Contract(vfsStream::url(self::DIR . DIRECTORY_SEPARATOR . self::FILENAME), $jsonDecoder);
    }
}