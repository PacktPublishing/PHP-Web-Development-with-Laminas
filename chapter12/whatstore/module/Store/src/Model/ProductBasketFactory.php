<?php
namespace Store\Model;

use Laminas\ServiceManager\Factory\FactoryInterface;

use Interop\Container\ContainerInterface;
use Laminas\Session\Container;
use Laminas\Stdlib\ArrayObject;

class ProductBasketFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        return new ProductBasket(new Container());
    }
}