<?php
declare(strict_types = 1);
namespace School\Controller;

use School\Model\StudentTable;
use School\Model\Student;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use School\Model\SchoolClassTable;

class StudentController extends AbstractActionController
{

    private ?StudentTable $studentTable = null;
    private ?SchoolClassTable $schoolClassTable = null;

    public function __construct(StudentTable $studentTable, SchoolClassTable $schoolClassTable)
    {
        $this->studentTable = $studentTable;
        $this->schoolClassTable = $schoolClassTable;
    }

    public function indexAction()
    {
        $students = $this->studentTable->getAll();
        return new ViewModel([
            'students' => $students
        ]);
    }
    
    public function editAction()
    {
        $id = $this->params('id');
        
        $student = $this->studentTable->getByField('ID',$id);
        
        return new ViewModel([
            'student' => $student,
            'schoolClasses' => $this->schoolClassTable->getAll()
        ]);
    }
    
    public function saveAction()
    {
        $id = (int) $this->request->getPost('id');
        $name = $this->request->getPost('name');
        $classCode = (int) $this->request->getPost('class_code');
        $model = new Student($id, $name, $classCode);
        $this->studentTable->save($model);
        
        return $this->redirect()->toRoute('student');
    }
    
    public function deleteAction()
    {
        $id = $this->params('id');
                
        $this->studentTable->delete($id);
        
        return $this->redirect()->toRoute('student');
    }
}