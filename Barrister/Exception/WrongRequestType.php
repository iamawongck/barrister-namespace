<?

class WrongRequestType extends \Exception {

    const MESSAGE = 'Mismatched request type caught by request handler.';

    public function __construct($message = self::MESSAGE) {
        parent::__construct($message);
    }
}
