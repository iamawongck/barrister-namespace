<?php


class NamespacedServerTest extends PHPUnit_Framework_TestCase {
    /**
     * @var \Barrister\Handler|PHPUnit_Framework_MockObject_MockObject
     */
    private $handler;

    /**
     * @var \Barrister\Server\NamespacedServer
     */
    private $server;

    protected function setUp() {
        $this->handler = $this->getMockForAbstractClass('\Barrister\Handler');

        $this->server = new \Barrister\Server\NamespacedServer($this->handler);
    }

    public function testHandle() {
        $jsonString = json_encode(array('method' => 'Fully\Qualified\Namespace.interface.method', 'params' => array()));

        $this->handler->expects($this->once())
            ->method("handle")
            ->will($this->returnCallback(function($request) {
                $this->assertInstanceOf('\Barrister\Request\NamespacedRequest', $request);

                return true;
            }));

        $this->server->handleJSONRequest(json_decode($jsonString));
    }
}
