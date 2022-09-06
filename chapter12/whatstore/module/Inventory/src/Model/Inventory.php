<?php
namespace Inventory\Model;

use Generic\Model\AbstractModel;

class Inventory extends AbstractModel
{
    public ?Product $product = null;
    public int $amount;
    public int $maximum;
    public int $minimum;
    public int $reserved;
    
    public function exchangeArray($data):void
    {
        $this->product = new Product();
        $this->product->code = ($data['code_product'] ?? 0);
        $this->product->name = ($data['product'] ?? '');
        $this->amount = ($data['amount'] ?? 0);
        $this->maximum = ($data['maximum'] ?? 0);
        $this->minimum = ($data['minimum'] ?? 0);
        $this->reserved = ($data['reserved'] ?? 0);
    }
    
    public function toArray()
    {
        $attributes = get_object_vars($this);
        unset($attributes['product']);
        $attributes['code_product'] = $this->product->code;
        return $attributes;
    }
    
    public function toFullArray()
    {
        $attributes = get_object_vars($this);
        $attributes['name'] = $this->product->name;
        unset($attributes['product']);
        $attributes['code_product'] = $this->product->code;
        return $attributes;
    }
    
    public function getArrayCopy()
    {
        return $this->toFullArray();
    }
}
