<?php
namespace Product\Model\Product;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ProductTableServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $tableGateway = $serviceLocator->get('Product\Model\Product\ProductTableGateway');
        $table = new ProductTable($tableGateway);
        return $table;
    }
}