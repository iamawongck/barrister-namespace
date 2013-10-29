<?
namespace Barrister;

interface Request {

    /** @return boolean */
    public function isValid();

    /** @return boolean */
    public function hasId();

    public function getId();
    
    public function toJSON();
}
