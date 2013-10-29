<?php


class ServerTest extends PHPUnit_Framework_TestCase {
    /**
     * @var \Barrister\Server|PHPUnit_Framework_MockObject_MockObject
     */
    private $server;

    /**
     * @var \Barrister\Handler|PHPUnit_Framework_MockObject_MockObject
     */
    private $handler;

    protected function setUp() {
        $this->handler = $this->getMockForAbstractClass('\Barrister\Handler');

        $this->server = $this->getMockForAbstractClass(
            '\Barrister\Server',
            array(
                $this->handler
            )
        );
    }

    public function testHandle() {
        $request = $this->getMockForAbstractClass('\Barrister\Request');

        $this->server->expects($this->once())
            ->method("makeRequestFromJSON")
            ->will($this->returnValue($request));

        $this->handler->expects($this->once())
            ->method("handle");

        $jsonString = json_encode(array('woop' => 1));

        $this->server->handleJSONRequest(json_decode($jsonString));
    }
}
