<?php
namespace Store\Model;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\Session\Container;
use Psr\Container\ContainerInterface;

class ProductBasketFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        return new ProductBasket(new Container());
    }
}