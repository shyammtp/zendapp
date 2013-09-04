<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Admin\Form\LoginForm; 
use Admin\Model\Login; 

class AdminController extends AbstractActionController
{ 
    protected $adminTable;
    protected $_loginModel;
    
    public function indexAction()
    { 
        $form = new LoginForm();
        $request = $this->getRequest();
        if ($request->isPost()) {
            
            $login = $this->getLoginModel();
            $form->setInputFilter($login->getInputFilter());
            $form->setData($request->getPost());
            $this->flashMessenger()->addMessage('Thank you for your comment!');
            if ($form->isValid()) {
                try
                {
                    $login->checkUserExists();
                    $login->exchangeArray($form->getData()); 
                    return $this->redirect()->toRoute('admin');
                }catch(\Exception $ex)
                {
                    
                }
            }
        }
        return array('form' => $form,
                     'user' => $this->getAdminTable()->getUser(1),
                     'flashMessages' => $this->flashMessenger()->getMessages());
    }
    
    public function getAdminTable()
    {
        if (!$this->adminTable) {
            $sm = $this->getServiceLocator();
            $this->adminTable = $sm->get('Admin\Model\AdminTable');
        }
        return $this->adminTable;
    }
    
    public function getLoginModel()
    {
        if (!$this->_loginModel) {
             $sm = $this->getServiceLocator();
            $this->_loginModel = $sm->get('Admin\Model\Login');
        }
        return $this->_loginModel;
    }
}
