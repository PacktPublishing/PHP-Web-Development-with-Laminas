<?php

declare(strict_types=1);

namespace SchoolTest\Controller;

use Laminas\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use School\Model\SchoolClass;

class StudentsControllerTest extends AbstractHttpControllerTestCase
{
    public function setUp(): void
    {
        $this->setApplicationConfig(
            include __DIR__ . '/../../../../config/application.config.php'
        );

        parent::setUp();
    }

    public function testListing(): void
    {
        $this->dispatch('/student', 'GET');
        $this->assertResponseStatusCode(200);
        $this->assertCommonRules();
    }
    
    public function testEditing(): void
    {
        $this->dispatch('/student/edit', 'GET');
        $this->assertResponseStatusCode(200);
        $this->assertCommonRules();
    }    
    
    public function testInserting(): void
    {
        $schoolClass = $this->getSchoolClass();
        $_POST['name'] = 'Joe Jackson';
        $_POST['class_code'] = $schoolClass->code;
        $this->dispatch('/student/save', 'POST', $_POST);
        $this->assertResponseStatusCode(302);
        $this->assertCommonRules();
        $studentTable = $this->getApplication()->getServiceManager()->get('StudentTable');
        $student = $studentTable->getByField('name', 'Joe Jackson');
        $this->assertEquals('Joe Jackson',$student->name);
        $id = $student->id;
        $student = $studentTable->getByField('id', $id);
        $this->assertEquals('Joe Jackson',$student->name);
        $studentTable->delete($id);
        $schoolClassTable = $this->getApplication()->getServiceManager()->get('SchoolClassTable');        
        $schoolClassTable->delete($schoolClass->code);
        $student = $studentTable->getByField('id', $id);
        $this->assertEmpty($student->name);}
    
    public function testUpdating(): void
    {
        $schoolClass = $this->getSchoolClass();
        $studentTable = $this->getApplication()->getServiceManager()->get('StudentTable');
        $student = $studentTable->getByField('name', '1st year');
        $_POST['id'] = $student->id;
        $_POST['name'] = 'Robbie Robertson';
        $_POST['class_code'] = $schoolClass->code;
        $this->dispatch('/student/save', 'POST', $_POST);
        $this->assertResponseStatusCode(302);
        $this->assertCommonRules();
        $student = $studentTable->getByField('name', 'Robbie Robertson');
        
        $this->assertEquals('Robbie Robertson', $student->name);
        
        $studentTable->delete($student->id);
        $schoolClassTable = $this->getApplication()->getServiceManager()->get('SchoolClassTable');
        $schoolClassTable->delete($schoolClass->code);
        
        $student = $studentTable->getByField('name', 'Robbie Robertson');
        
        $this->assertEmpty($student->name);
    }

    private function assertCommonRules(): void
    {
        $this->assertModuleName('school');
        $this->assertControllerName('student'); // as specified in router's controller name alias
        $this->assertControllerClass('StudentController');
        $this->assertMatchedRouteName('student');        
    }
    
    private function getSchoolClass(): SchoolClass
    {
        $schoolClassTable = $this->getApplication()->getServiceManager()->get('SchoolClassTable');
        $schoolClass = new SchoolClass(0,'1st year');
        $schoolClassTable->save($schoolClass);
        return $schoolClassTable->getByField('name', '1st year');
    }
}
