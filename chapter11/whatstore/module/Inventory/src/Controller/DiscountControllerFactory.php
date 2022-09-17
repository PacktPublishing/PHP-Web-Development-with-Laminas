<?php
namespace Inventory\Controller;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class DiscountControllerFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $discountTable = $container->get('DiscountTable');
        return new DiscountController($discountTable);
    }
}