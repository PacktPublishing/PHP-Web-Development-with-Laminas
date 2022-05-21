<?php

declare(strict_types=1);

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Application\Form\UploadForm;
use Laminas\View\Model\JsonModel;
use Application\Validator\Palindrome;
use Application\Filter\Zatanna;

class IndexController extends AbstractActionController
{
    const TARGET_DIR =  APP_ROOT . DIRECTORY_SEPARATOR . 
    'public' . DIRECTORY_SEPARATOR .
    'img' . DIRECTORY_SEPARATOR;
    
    public function indexAction()
    {
        return new ViewModel();
    }
    
    public function showJsonAction()
    {
        $simpleValue = 'a simple text';
        $list = ['apple','banana', 'coconut'];
        $car = new \stdClass();
        $car->color = 'red';
        $car->wheels = 4;
        
        return new JsonModel([
            'simple-value' => $simpleValue,
            'array' => $list,
            'object' => $car
        ]);
    }
    
    public function showImageAction()
    {
        return new ViewModel();
    }
    
    public function uploadFormAction()
    {
        $form = new UploadForm('upload-form');
        $form->setAttribute('action',$this->url()->fromRoute('application',
            ['action' => 'upload-form']
        ));
        
        $data = [];
        $request = $this->getRequest();
        if ($request->isPost()) {
            // Make certain to merge the $_FILES info!
            $post = array_merge_recursive(
                $request->getPost()->toArray(),
                $request->getFiles()->toArray()
                );
            
            $form->setData($post);
            if ($form->isValid()) {
                $data = $form->getData();
                $content = file_get_contents($data['image-file']['tmp_name']);

                file_put_contents(self::TARGET_DIR . 'image.jpg', $content);
            }
        }
        return new ViewModel([
            'form' => $form,
            'data' => $data
        ]);
    }
    
    public function filterAction()
    {
        $expression = $this->getRequest()->getPost('expression');
        if (empty($expression)){
            $response = '';
        } else {
            $filter = new Zatanna();
            $response = 'Zatanna says: ' . $filter->filter($expression);
        }
        return new ViewModel([
            'expression' => $expression,
            'response' => $response
        ]);
    }
    
    public function validatorAction()
    {
        $expression = $this->getRequest()->getPost('expression');
        if (empty($expression)){
            $response = '';
        } else {
            $validator = new Palindrome();
            $response = 'It is not a palindrome!';
            if ($validator->isValid($expression)){
                $response = 'It is a palindrome!';
            }
        }
        return new ViewModel([
            'expression' => $expression,
            'response' => $response            
        ]);
    }
    
    public function ajaxAction()
    {
        if ($this->getRequest()->isXmlHttpRequest()){
            return new JsonModel();
        }
        return new ViewModel();
    }
    
    public function changeLayoutAction()
    {
        $this->layout()->setTemplate('/layout/otherlayout');
        return new ViewModel();       
    }
    
    public function flashMessengerAction()
    {
        $this->flashMessenger()->addMessage('You called this action at ' . date('H:i:s'));
        $messages = $this->flashMessenger()->getMessages();
        return new ViewModel(['messages' => $messages]);
    }
    
}
