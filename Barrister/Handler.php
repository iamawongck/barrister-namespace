<?
namespace Barrister;

interface Handler {

    /**
     * @param Request $request
     * @return Response
     */
    public function handle(Request $request);
}
