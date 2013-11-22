<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin\Controller\Settings;
  
use Zend\View\Model\ViewModel;
use Core\Controller\AbstractController as CoreController;
use Admin\Form\Settings\General\Form as Generalform;

class GeneralController extends CoreController
{
    
    private $workingDays = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
    
    private $_generalForm;
    
    private function getGeneralFormObject()
    {
        if(!$this->_generalForm)
        {
            $this->_generalForm = \Ething::getClassInstance('Admin\Form\Settings\General\Form');
        }
        return $this->_generalForm;
    }
    
    public function indexAction()
    {
        
        return $this->loadSettingsForm('admin_settings_general');  
    }
    
    public function webAction()
    { 
        return $this->loadSettingsForm('admin_settings_general_web');
    }
     
    public function saveAction()
    {
        $request = $this->getRequest();
        
        $this->getGeneralFormObject()->setData($request->getPost());
        if ($request->isPost()) {
            try
            {
                $this->configurationTable()->setData($request->getPost())->save();
                $this->flashMessenger()->addSuccessMessage('Saved successfully');
                
            }catch(\Exception $e)
            { }
        }
        return $this->redirect()->toRoute('settings',array('action' => $request->getPost('current_action') ));
    }
    
}
