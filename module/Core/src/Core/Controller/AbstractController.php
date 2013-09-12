<?php
namespace Core\Controller; 

use Zend\View\Model\ViewModel;
use Core\Model\Functions;
use Core\Controller\Main\Functions as Corefunction;

class AbstractController extends Corefunction
{
    
    protected $_countryTable;
    
    protected $_functionModel;
     
    
    public function getCountryTable()
    {
         
        if (!$this->_countryTable) {
            $sm = $this->getServiceLocator();
            $this->_countryTable = $sm->get('Core\Model\Country');
        }
        return $this->_countryTable;
    } 
    
}