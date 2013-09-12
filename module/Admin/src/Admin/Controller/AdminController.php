<?php 
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin\Controller;

use Core\Controller\AbstractController as CoreController; 
use Admin\Form\LoginForm; 
use Admin\Model\Login; 

class AdminController extends CoreController
{ 
    protected $adminTable;
    protected $_loginModel;
    protected $authservice;
    protected $storage;
    
    protected function _getAuthService()
    {
        if (!$this->authservice) {
            $this->authservice = $this->getServiceLocator()
                                      ->get('AuthService');
        } 
        return $this->authservice;
    }
    
    protected function getSessionStorage()
    {
        if (! $this->storage) {
            $this->storage = $this->getServiceLocator()
                                  ->get('Admin\Model\Login\AuthStorage');
        }  
        return $this->storage;
    }
     
     
    public function indexAction()
    {
        if ($this->_getAuthService()->hasIdentity()){
            return $this->redirect()->toRoute('dashboard');
        }
        $this->layout('layout/loginlayout');
        $form = new LoginForm(); 
        $request = $this->getRequest();
        if ($request->isPost()) {
            
            $login = $this->getLoginModel(); 
            $form->setInputFilter($login->getInputFilter());
            $form->setData($request->getPost());
            
            if($form->isValid()) {
                try
                {
                    $this->getAdminTable()->checkLogin($request->getPost('username'),
                                                       $request->getPost('password')); 
                    $login->exchangeArray($form->getData());
                    $this->_getAuthService()->getAdapter()
                                       ->setIdentity($request->getPost('username'))
                                       ->setCredential($request->getPost('password'));
                    $result = $this->_getAuthService()->authenticate();
                    if ($result->isValid()) {
                        $this->_getAuthService()->getStorage()->write($request->getPost('username'));
                        $this->flashMessenger()->addSuccessMessage('Logged successfully');
                        return $this->redirect()->toRoute('dashboard');
                    }
                }
                catch(\Exception $ex)
                {
                    $this->flashMessenger()->addErrorMessage('User / Password not exists');
                    $this->redirect()->toRoute('admin');
                }
            }
        }
        return array('form' => $form, 
                     'flashSuccessMessages' => $this->flashMessenger()->getSuccessMessages(), 
                     'flashErrorMessages' => $this->flashMessenger()->getErrorMessages());
    }
    
    public function logoutAction()
    { 
        $this->_getAuthService()->clearIdentity(); 
        $this->flashmessenger()->addMessage("You've been logged out");
        return $this->redirect()->toRoute('admin');
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
