<?php
namespace SchoolTest;

use PHPUnit\Framework\TestCase;
use School\SchoolClass;
use Laminas\Db\Adapter\Adapter;
use School\Student;
use School\StudentTable;
use School\SchoolClassTable;

class StudentTest extends TestCase
{
    public function testListing()
    {
        $rows = StudentTable::getInstance()->getAll();
        $this->assertIsIterable($rows);
    }
    
    public function testInserting()
    {
        $studentTable = StudentTable::getInstance();
        $schoolClassTable = SchoolClassTable::getInstance();
        
        $schoolClass = $this->getSchoolClass($schoolClassTable);
        
        $student = new Student(0,'Joe Jackson',$schoolClass->code);
        $studentTable->save($student);
        
        $student = StudentTable::getInstance()->getByField('name', 'Joe Jackson');
        $this->assertEquals('Joe Jackson',$student->name);
        $id = $student->id;
        $student = StudentTable::getInstance()->getByField('id', $id);
        $this->assertEquals('Joe Jackson',$student->name);
        $studentTable->delete($id);
        $schoolClassTable->delete($schoolClass->code);
        $student = StudentTable::getInstance()->getByField('id', $id);
        $this->assertEmpty($student->name);
    }
    
    public function testUpdating()
    {
        $studentTable = StudentTable::getInstance();
        $schoolClassTable = SchoolClassTable::getInstance();

        $schoolClass = $this->getSchoolClass($schoolClassTable);
        
        $student = new Student(0,'Joe Jackson',$schoolClass->code);
        $studentTable->save($student);
        
        $student = StudentTable::getInstance()->getByField('name', 'Joe Jackson');
        $student->name = 'Robbie Robertson';
        $studentTable->save($student);
        
        $student = StudentTable::getInstance()->getByField('name', 'Robbie Robertson');
        
        $this->assertEquals('Robbie Robertson', $student->name);
        
        $studentTable->delete($student->id);
        $schoolClassTable->delete($schoolClass->code);
        
        $student = StudentTable::getInstance()->getByField('name', 'Robbie Robertson');
        
        $this->assertEmpty($student->name);
    }
    
    private function getSchoolClass(SchoolClassTable $schoolClassTable): SchoolClass
    {
        $schoolClass = new SchoolClass(0,'1st year');
        $schoolClassTable->save($schoolClass);
        return SchoolClassTable::getInstance()->getByField('name', '1st year');        
    }
}
