<?php
declare(strict_types = 1);
namespace School;

class Student extends AbstractModel
{

    public int $id = 0;

    public string $name = '';

    public ?SchoolClass $schoolClass = null;
    
    public function __construct(int $id = 0, string $name = '', int $class_code = 0)
    {
        $this->id = $id;
        $this->name = $name;
        $this->schoolClass = new SchoolClass($class_code,'');
    }
    
    public function exchangeArray($data)
    {
        $this->id = ((int) $data['ID'] ?? 0);
        $this->name = ($data['name'] ?? '');
        $this->schoolClass = new SchoolClass();
        $this->schoolClass->code = ((int) $data['class_code'] ?? 0);
        $this->schoolClass->name = ($data['class_name'] ?? '');
    }

    public function toArray()
    {
        $attributes = get_object_vars($this);
        $attributes['class_code'] = $attributes['schoolClass']->code;
        unset($attributes['schoolClass']);
        return $attributes;
    }
}