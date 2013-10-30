<?
namespace Barrister;

use Barrister\Request\AbstractRequest;

interface Handler {

    /**
     * @param AbstractRequest $request
     * @return mixed
     */
    public function handle(AbstractRequest $request);
}
