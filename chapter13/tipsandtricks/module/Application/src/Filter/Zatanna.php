<?php
namespace Application\Filter;

use Laminas\Filter\FilterInterface;

class Zatanna implements FilterInterface
{
    public function filter($value)
    {
        return strtolower(strrev($value));
    }
}

