<?

class NamespacedRequestTest extends PHPUnit_Framework_TestCase {

    public function setUp() {

    }

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
}
