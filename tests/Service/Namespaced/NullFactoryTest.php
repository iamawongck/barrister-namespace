<?

class NamespacedServiceFactoryTest extends PHPUnit_Framework_TestCase {

    const TEST_NAME = ContractTest::VALID_INTERFACE;
    const TEST_NAMESPACE = 'Namespace';
    const TEST_BAD_NAME = ContractTest::INVALID_NAME;

    /** @var \Barrister\Contract */
    private $contract;

    /** @var \Barrister\Service\Namespaced\NamespacedServiceFactory */
    private $factory;

    public function setUp() {
        $factoryTest = new FactoryTest();
        $this->contract = $factoryTest->getContract(FactoryTest::IDL_JSON);
        $this->factory = new \Barrister\Service\Namespaced\NullFactory($this->contract);
    }

    public function testGetService() {
        $service = $this->factory->getService(self::TEST_NAME);
        $this->assertInstanceOf('\Barrister\Service', $service);
    }

    public function testGetServiceByNamespace() {
        $service = $this->factory->getServiceByNamespace(self::TEST_NAMESPACE, self::TEST_NAME);
        $this->assertInstanceOf('\Barrister\Service', $service);
    }

    /**
     * @expectedException \Barrister\Exception\Service\InvalidInterfaceException
     */
    public function testBadServiceName() {
        $this->factory->getServiceByNamespace(self::TEST_NAMESPACE, self::TEST_BAD_NAME);
    }
}
