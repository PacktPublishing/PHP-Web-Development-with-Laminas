<?php
namespace SchoolTest;

use PHPUnit\Framework\TestCase;
use School\SchoolClass;
use Laminas\Db\Adapter\Adapter;

class SchoolClassTest extends TestCase
{
    public function testListing()
    {
        $rows = SchoolClass::getAll();
        $this->assertIsIterable($rows);
    }
    
    public function testInserting()
    {
        $schoolClass = new SchoolClass(0,'1st year');
        $schoolClass->save();
        
        $schoolClass = SchoolClass::getByName('1st year');
        $this->assertEquals('1st year',$schoolClass->name);
        $code = $schoolClass->code;
        $schoolClass = SchoolClass::getByCode($code);
        $this->assertEquals('1st year',$schoolClass->name);
        $schoolClass->delete();
        $schoolClass = SchoolClass::getByCode($code);
        $this->assertEmpty($schoolClass->name);
    }
    
    public function testUpdating()
    {
        $schoolClass = new SchoolClass(0,'1st year');
        $schoolClass->save();
        
        $schoolClass = SchoolClass::getByName('1st year');
        $schoolClass->name = '2nd year';
        $schoolClass->save();
        
        $schoolClass = SchoolClass::getByName('2nd year');
        
        $this->assertEquals('2nd year', $schoolClass->name);
        
        $schoolClass->delete();
        
        $schoolClass = SchoolClass::getByName('2nd year');
        
        $this->assertEmpty($schoolClass->name);
    }
}

