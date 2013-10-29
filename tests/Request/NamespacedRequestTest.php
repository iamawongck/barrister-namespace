<?

class NamespacedRequestTest extends PHPUnit_Framework_TestCase {

    const NAMESPACE_NAME = 'Namespace';
    const INTERFACE_NAME = 'Interface';
    const FUNCTION_NAME = 'Method';

    /**
     * @dataProvider provideInvalidMethods
     * @param $method
     */
    public function testIsValidWithBadMethods($method) {
        $request = new Barrister\Request\NamespacedRequest($method, array());
        $this->assertFalse($request->isValid());
    }

    public function provideInvalidMethods() {
        return array(
            array('NamespaceOnly'), array('Namespace.InterfaceOnly'), array('Namespace\Interface\Method')
        );
    }

    /**
     * @dataProvider provideValidMethods
     * @param $method
     */
    public function testIsValidWithGoodMethods($method) {
        $request = new Barrister\Request\NamespacedRequest($method, array());
        $this->assertTrue($request->isValid());
    }

    public function provideValidMethods() {
        return array(
            array('Namespace.Interface.Method'), array('NamespaceSegment.NamespaceSegment.Interface.Method')
        );
    }

    public function testGetNamespace() {
        $request = $this->getValidRequest();
        $this->assertEquals(self::NAMESPACE_NAME, $request->getNamespace());
    }

    public function testGetInterface() {
        $request = $this->getValidRequest();
        $this->assertEquals(self::INTERFACE_NAME, $request->getInterface());
    }

    public function testGetFunction() {
        $request = $this->getValidRequest();
        $this->assertEquals(self::FUNCTION_NAME, $request->getFunction());
    }

    public function testGetMethod() {
        $request = $this->getValidRequest();
        $this->assertEquals($this->getMethod(), $request->getMethod());
    }

    private function getValidRequest() {
        return new Barrister\Request\NamespacedRequest($this->getMethod(), array());
    }

    private function getMethod() {
        return self::NAMESPACE_NAME . '.' . self::INTERFACE_NAME . '.' . self::FUNCTION_NAME;
    }
}
