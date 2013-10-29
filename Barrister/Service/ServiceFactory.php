<?
namespace Barrister\Service;

use Barrister\Service;

interface ServiceFactory {

    /** @returns Service */
    public function getService($name);

}
