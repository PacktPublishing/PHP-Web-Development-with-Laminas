<?php
declare(strict_types=1);
namespace Generic\Filter;

use Laminas\Filter\FilterInterface;

class Encrypt implements FilterInterface
{
    public function filter($value)
    {
        $value = strrev(hash('sha256', $value));
        return hash('md5', $value);
    }
}