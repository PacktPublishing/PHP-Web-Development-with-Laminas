<?php

declare(strict_types=1);

namespace SchoolTest\Controller;

use Laminas\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class SchoolClassControllerTest extends AbstractHttpControllerTestCase
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
        $this->dispatch('/schoolclass', 'GET');
        $this->assertResponseStatusCode(200);
        $this->assertCommonRules();
    }
    
    public function testEditing(): void
    {
        $this->dispatch('/schoolclass/edit', 'GET');
        $this->assertResponseStatusCode(200);
        $this->assertCommonRules();
    }    
    
    public function testInserting(): void
    {
        $_POST['name'] = '1st year';
        $this->dispatch('/schoolclass/save', 'POST', $_POST);
        $this->assertResponseStatusCode(302);
        $this->assertCommonRules();
        $schoolClassTable = $this->getApplication()->getServiceManager()->get('SchoolClassTable');
        $schoolClass = $schoolClassTable->getByField('name', '1st year');
        $this->assertEquals('1st year', $schoolClass->name);
    }
    
    public function testUpdating(): void
    {
        $schoolClassTable = $this->getApplication()->getServiceManager()->get('SchoolClassTable');
        $schoolClass = $schoolClassTable->getByField('name', '1st year');
        $_POST['code'] = $schoolClass->code;
        $_POST['name'] = '2nd year';
        $this->dispatch('/schoolclass/save', 'POST', $_POST);
        $this->assertResponseStatusCode(302);
        $this->assertCommonRules();
        $schoolClass = $schoolClassTable->getByField('code', (int) $_POST['code']);
        $this->assertEquals('2nd year', $schoolClass->name);
    }
    
    public function testDeleting(): void
    {
        $schoolClassTable = $this->getApplication()->getServiceManager()->get('SchoolClassTable');
        $schoolClass = $schoolClassTable->getByField('name', '2nd year');
        $this->dispatch('/schoolclass/delete/' . $schoolClass->code, 'GET');
        $this->assertResponseStatusCode(302);
        $this->assertCommonRules();
        $schoolClass = $schoolClassTable->getByField('name', '2nd year');
        $this->assertEquals('', $schoolClass->name);
    }

    private function assertCommonRules(): void
    {
        $this->assertModuleName('school');
        $this->assertControllerName('schoolclass'); // as specified in router's controller name alias
        $this->assertControllerClass('SchoolClassController');
        $this->assertMatchedRouteName('schoolclass');        
    }
}
