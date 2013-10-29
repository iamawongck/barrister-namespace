<?

class NamespacedRequestTest extends PHPUnit_Framework_TestCase {

    const TEST_METHOD = 'CK.TestMethod';

    public function setUp() {

    }

    public function testIsValid() {
        $request = new Barrister\Request\NamespacedRequest(self::TEST_METHOD, array());
    }
}
