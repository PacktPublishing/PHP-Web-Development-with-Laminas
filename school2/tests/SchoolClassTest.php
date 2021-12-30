<?php
namespace SchoolTest;

use PHPUnit\Framework\TestCase;
use School\SchoolClass;
use Laminas\Db\Adapter\Adapter;
use School\SchoolClassTable;

class SchoolClassTest extends TestCase
{
    public function testListing()
    {
        $rows = SchoolClassTable::getInstance()->getAll();
        $this->assertIsIterable($rows);
    }
    
    public function testInserting()
    {
        $schoolClassTable = SchoolClassTable::getInstance();
        
        $schoolClass = new SchoolClass(0,'1st year');
        $schoolClassTable->save($schoolClass);
        
        $schoolClass = SchoolClassTable::getInstance()->getByField('name', '1st year');
        $this->assertEquals('1st year',$schoolClass->name);
        $code = $schoolClass->code;
        $schoolClass = SchoolClassTable::getInstance()->getByField('code', $code);
        $this->assertEquals('1st year',$schoolClass->name);
        $schoolClassTable->delete($schoolClass->code);
        $schoolClass = SchoolClassTable::getInstance()->getByField('code', $code);
        $this->assertEmpty($schoolClass->name);
    }
    
    public function testUpdating()
    {
        $schoolClassTable = SchoolClassTable::getInstance();
        
        $schoolClass = new SchoolClass(0,'1st year');
        $schoolClassTable->save($schoolClass);
        
        $schoolClass = SchoolClassTable::getInstance()->getByField('name', '1st year');
        $schoolClass->name = '2nd year';
        $schoolClassTable->save($schoolClass);
        
        $schoolClass = SchoolClassTable::getInstance()->getByField('name', '2nd year');
        
        $this->assertEquals('2nd year', $schoolClass->name);
        
        $schoolClassTable->delete($schoolClass->code);
        
        $schoolClass = SchoolClassTable::getInstance()->getByField('name', '2nd year');
        
        $this->assertEmpty($schoolClass->name);
    }
}
