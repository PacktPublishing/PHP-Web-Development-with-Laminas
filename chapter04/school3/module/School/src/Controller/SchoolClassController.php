<?php
declare(strict_types = 1);
namespace School\Controller;

use School\Model\SchoolClassTable;
use School\Model\SchoolClass;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class SchoolClassController extends AbstractActionController
{

    private ?SchoolClassTable $schoolClassTable = null;

    public function __construct(SchoolClassTable $schoolClassTable)
    {
        $this->schoolClassTable = $schoolClassTable;
    }

    public function indexAction()
    {
        $schoolClasses = $this->schoolClassTable->getAll();
        return new ViewModel([
            'schoolClasses' => $schoolClasses
        ]);
    }
    
    public function editAction()
    {
        $code = $this->params('code');
        
        $schoolClass = $this->schoolClassTable->getByField('code',$code);
        
        return new ViewModel([
            'schoolClass' => $schoolClass
        ]);
    }
    
    public function saveAction()
    {
        $code = (int) $this->request->getPost('code');
        $name = $this->request->getPost('name');
        $model = new SchoolClass($code, $name);
        $this->schoolClassTable->save($model);
        
        return $this->redirect()->toRoute('schoolclass');
    }
    
    public function deleteAction()
    {
        $code = $this->params('code');
                
        $this->schoolClassTable->delete($code);
        
        return $this->redirect()->toRoute('schoolclass');
    }
}