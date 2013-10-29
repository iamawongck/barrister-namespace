<?

class ContractTest extends PHPUnit_Framework_TestCase {

    const VALID_INTERFACE = 'Service';
    const VALID_STRUCT = 'Entry';
    const INVALID_NAME = 'ERROR';

    /** @var \Barrister\Contract */
    private $contract;

    public function setUp() {
        $factoryTest = new FactoryTest();
        $this->contract =  $factoryTest->getContract(FactoryTest::IDL_JSON);
    }

    public function testValidateInterfaceUsingInvalidName() {
        $this->assertFalse($this->contract->validateInterface(self::INVALID_NAME));
    }

    public function testValidateInterfaceUsingValidName() {
        $this->assertTrue($this->contract->validateInterface(self::VALID_INTERFACE));
    }

    public function testValidateStructUsingInvalidName() {
        $this->assertFalse($this->contract->validateStruct(self::INVALID_NAME));
    }

    public function testValidateStructUsingValidName() {
        $this->assertTrue($this->contract->validateStruct(self::VALID_STRUCT));
    }
}
