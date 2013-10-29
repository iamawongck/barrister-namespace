<?
namespace Barrister;

abstract class Server {
    /**
     * @var Handler
     */
    private $handler;

    /**
     * @param Handler $handler
     */
    public function __construct(Handler $handler) {
        $this->handler = $handler;
    }

    /**
     * @param \stdClass $json
     * @return Request
     */
    protected abstract function makeRequestFromJSON($json);

    /**
     * @param \stdClass $jsonRequest
     * @return Response
     */
    public function handleJSONRequest($jsonRequest) {
        return $this->handler->handle($this->makeRequestFromJSON($jsonRequest));
    }
}
