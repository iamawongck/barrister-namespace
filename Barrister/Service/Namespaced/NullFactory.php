<?
namespace Barrister\Service\Namespaced;

use Barrister\Service;

class NullService implements \Barrister\Service {}

class NullFactory extends \Barrister\Service\Namespaced\NamespacedServiceFactory {

    /** @returns Service */
    public function getService($name) {
        return new NullService();
    }

}
