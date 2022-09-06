<?php
namespace Inventory\Model;

use Generic\Model\AbstractModel;

class Product extends AbstractModel
{
    public int $code;
    public String $name;
    public float $price;
    public Discount $discount;
    
    public function exchangeArray($data):void
    {
        $this->code = ($data['code'] ?? 0);
        $this->name = ($data['name'] ?? '');
        $this->price = ($data['price'] ?? 0.0);
        $this->discount = new Discount();
        $this->discount->code = ($data['code_discount'] ?? 0);
        $this->discount->name = ($data['name_discount'] ?? '');        
    }
    
    public function toArray()
    {
        $attributes = get_object_vars($this);
        unset($attributes['discount']);
        unset($attributes['name_discount']);
        $attributes['code_discount'] = $this->discount->code;
        return $attributes;
    }    
}
