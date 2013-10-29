<?
namespace Barrister;

class Server {

    /** @var Handler */
    private $handler;

    public function __construct(Handler $handler) {
        $this->handler = $handler;
    }

    public function handle(Request $request) {
        return $this->handler->handle($request);
    }
}
