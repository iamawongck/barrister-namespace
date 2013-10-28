<?
namespace Barrister;

use Barrister\Request;

interface Response {

    public function __construct(Request $request);

    public function toString();
}
