<?php
namespace Inventory\Model;

use Generic\Model\AbstractModel;

class Discount extends AbstractModel
{
    public int $code;
    public string $name;
    public string $operator;
    public float $factor;
    
    public function exchangeArray($data)
    {
        $this->code = ($data['code'] ?? 0);
        $this->name = ($data['name'] ?? '');
        $this->operator = ($data['operator'] ?? '');
        $this->factor = ($data['factor'] ?? 0.0);
    }
}