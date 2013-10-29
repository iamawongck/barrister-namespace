<?php


class HandlerMapperTest extends PHPUnit_Framework_TestCase {
    const NAMESPACEING = "Namespace";

    const METHODING = "Method";

    const IFACE = "Iface";

    /**
     * @var \Barrister\Handler\HandlerMapper
     */
    private $mapper;

    protected function setUp() {
        $this->mapper = new \Barrister\Handler\HandlerMapper();
    }

    /**
     * @expectedException \Barrister\Exception\WrongRequestType
     */
    public function testHandleNotNamespacedRequest() {
        $this->mapper->handle(new \Barrister\Request\NullRequest());
    }

    /**
     * @expectedException \Barrister\Exception\RequestException
     */
    public function testHandleDoesntHaveNamespacedKey() {
        $request = new Barrister\Request\NamespacedRequest(
            implode(".", array(self::NAMESPACEING, self::IFACE, self::METHODING)),
            array()
        );

        $this->mapper->handle($request);
    }

    public function testHandle() {
        $handler = $this->getMockForAbstractClass('\Barrister\Handler');
        $handler->expects($this->once())
            ->method("handle")
            ->will($this->returnValue(true));

        $this->mapper->addHandler(self::NAMESPACEING, $handler);

        $request = new Barrister\Request\NamespacedRequest(
            implode(".", array(self::NAMESPACEING, self::IFACE, self::METHODING)),
            array()
        );

        $this->assertTrue($this->mapper->handle($request));
    }
}
