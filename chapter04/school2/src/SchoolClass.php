<?php
declare(strict_types = 1);
namespace School;

class SchoolClass extends AbstractModel
{

    public int $code = 0;

    public string $name = '';

    public function __construct(int $code = 0, string $name = '')
    {
        $this->code = $code;
        $this->name = $name;
    }
}