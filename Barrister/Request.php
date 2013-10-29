<?
namespace Barrister;

interface Request {

    public function isValid();

    public function toJSON();
}
