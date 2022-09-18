<?php
namespace Store\Model;

use Laminas\Session\Container;

class ProductBasket
{
    private Container $container;
    
    public function __construct(Container $container)
    {
        $this->container = $container;
        if (!isset($this->container->productBasket)){
            $this->container->productBasket = [];
        }
    }
    
    public function create(array $data): bool
    {        
        $inserted = false;
        if (isset($this->container->productBasket[$data['code']])){
            $this->container->productBasket[$data['code']]['amount'] += $data['amount'];
            $inserted = true;
        } else {
            $this->container->productBasket[$data['code']] = $data;
            $inserted = true;
        }
        return $inserted;
    }
    
    public function update(int $id, array $data): bool
    {
        $updated = false;
        if (!isset($this->container->productBasket[$id]))
        {
            return $updated;
        }
        $operation = ($data['operation'] ?? 'invalid');
        if ($operation == 'add'){
            $this->container->productBasket[$id]['amount']++;
            $updated = true;
        }
        if ($operation == 'sub' && ($this->container->productBasket[$id]['amount'] > 1)){
            $this->container->productBasket[$id]['amount']--;
            $updated = true;
        }
        return $updated;
    }
    
    public function delete(int $id): bool
    {
        if (!isset($this->container->productBasket[$id])){
            return false;
        }
        unset($this->container->productBasket[$id]);
        return true;
    }
    
    public function clear(): void
    {
        $this->container->productBasket = [];
    }
    
    public function getProducts(): array
    {
        return $this->container->productBasket;
    }
    
    public function get(int $id): array
    {
        if (!isset($this->container->productBasket[$id])){
            return [];
        }
        return $this->container->productBasket[$id];
    }
}