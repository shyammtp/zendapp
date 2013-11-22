<?php
namespace Core\Controller; 

use Zend\View\Model\ViewModel;
use Core\Model\Functions;
use Core\Controller\Main\Functions as Corefunction; 

class AbstractController extends Corefunction
{
    
    protected $_countryTable; 
    
    protected $_configurationTable;
    
    public function getCountryTable()
    { 
        if (!$this->_countryTable) {
            $sm = $this->getServiceLocator();
            $this->_countryTable = $sm->get('Core\Model\Country');
        }
        return $this->_countryTable;
    }
    
    public function configurationTable()
    { 
         if (!$this->_configurationTable) {
            $sm = $this->getServiceLocator();
            $this->_configurationTable = $sm->get('Core\Model\Configuration');
        }
        return $this->_configurationTable;
    }
    
    public function getSiteConfig($path)
    {
        return $this->_configurationTable->getConfigValue($path);
    }
    
    public function loadSettingsForm($indexPath)
    {
        $settingForm = \Ething::config()->getSettingForm($indexPath);
        $form = \Ething::getClassInstance('Core\Form\SettingsForm',array('name'))->addFields($settingForm)
        ->addCountry($this->getCountryTable()->fetchAll())
        ->load();
        $form->setData($this->getRequest()->getPost());
        $bind = array('form' => $form,
                      'settingForm' => $settingForm);
        $view = new ViewModel($bind); 
        $view->setTemplate('admin/settings/general/index2');
         
        
        return $view;
    }
    
}