<?

class ContractTest extends PHPUnit_Framework_TestCase {

    const VALID_INTERFACE = 'Service';
    const VALID_STRUCT = 'Entry';
    const VALID_ENUM = 'AccountType';
    const VALID_META = 'barrister_version';
    const INVALID_NAME = 'ERROR';

    /** @var \Barrister\Contract */
    private $contract;

    public function setUp() {
        $factoryTest = new FactoryTest();
        $this->contract =  $factoryTest->getContract(FactoryTest::IDL_JSON);
    }

    public function testValidateInterface() {
        $this->assertTrue($this->contract->validateInterface(self::VALID_INTERFACE));
    }

    public function testValidateStruct() {
        $this->assertTrue($this->contract->validateStruct(self::VALID_STRUCT));
    }

    public function testValidateEnum() {
        $this->assertTrue($this->contract->validateEnum(self::VALID_ENUM));
    }

    public function testValidateMeta() {
        $this->assertTrue($this->contract->validateMeta(self::VALID_META));
    }

    public function testValidateInterfaceUsingInvalidName() {
        $this->assertFalse($this->contract->validateInterface(self::INVALID_NAME));
        $this->assertFalse($this->contract->validateInterface(self::VALID_ENUM), 'Enum should not map to Interface');
        $this->assertFalse($this->contract->validateInterface(self::VALID_STRUCT), 'Struct should not map to Interface');
        $this->assertFalse($this->contract->validateInterface(self::VALID_META), 'Meta should not map to Interface');
    }

    public function testValidateStructUsingInvalidName() {
        $this->assertFalse($this->contract->validateStruct(self::INVALID_NAME));
        $this->assertFalse($this->contract->validateStruct(self::VALID_ENUM), 'Enum should not map to Struct');
        $this->assertFalse($this->contract->validateStruct(self::VALID_INTERFACE), 'Interface should not map to Struct');
        $this->assertFalse($this->contract->validateStruct(self::VALID_META), 'Meta should not map to Struct');
    }

    public function testValidateEnumUsingInvalidName() {
        $this->assertFalse($this->contract->validateEnum(self::INVALID_NAME));
        $this->assertFalse($this->contract->validateEnum(self::VALID_STRUCT), 'Struct should not map to Enum');
        $this->assertFalse($this->contract->validateEnum(self::VALID_INTERFACE), 'Interface should not map to Enum');
        $this->assertFalse($this->contract->validateEnum(self::VALID_META), 'Meta should not map to Enum');
    }


    public function testValidateMetaUsingInvalidName() {
        $this->assertFalse($this->contract->validateMeta(self::INVALID_NAME));
        $this->assertFalse($this->contract->validateMeta(self::VALID_ENUM), 'Enum should not map to Meta');
        $this->assertFalse($this->contract->validateMeta(self::VALID_INTERFACE), 'Interface should not map to Meta');
        $this->assertFalse($this->contract->validateMeta(self::VALID_STRUCT), 'Struct should not map to Meta');
    }

}
