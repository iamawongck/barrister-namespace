<?
namespace Barrister;

interface Request {

    /** @return boolean */
    public function isValid();

    /** @return string */
    public function toJSON();

    /** @return boolean */
    public function hasId();

    /** @return int */
    public function getId();
}
