<?
namespace Barrister\Service\Namespaced;

use Barrister\Service;
use Barrister\Contract;
use Barrister\Exception\Service\InvalidInterfaceException;
use Barrister\Service\ServiceFactory;

abstract class NamespacedServiceFactory implements ServiceFactory {

    private $contract;

    public function __construct(Contract $contract) {
        $this->contract = $contract;
    }

    /**
     * @param string $namespace
     * @param string $name
     * @throws InvalidInterfaceException
     * @return mixed
     */
    public function getServiceByNamespace($namespace, $name) {

        try {
            $this->contract->getInterface($name);
        } catch (InvalidInterfaceException $e) {
            throw $e;
        }

        $fullClassName = $namespace . "/" . $name;
        return $this->getService($fullClassName);
    }

}
