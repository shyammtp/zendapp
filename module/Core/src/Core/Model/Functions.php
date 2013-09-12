<?php
namespace Core\Model;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Functions implements ServiceLocatorAwareInterface
{  
    protected $_db;
    protected $serviceLocator;
    
    public function setDBAdapter($dbAdapter)
    {
        if(!$this->_db)
        {
            $this->_db = $dbAdapter;
        }
        return $this->_db;
    }
     
    public function getDBAdapter()
    {
        return $this->_db;
    }
    
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator) {
        $this->serviceLocator = $serviceLocator;
    }
    
    public function getServiceLocator() {
        return $this->serviceLocator;
    }

    
    public function getClassInstance($modelClass,$arguments)
    {
        if(''!=$modelClass)
        {
            return new $modelClass($arguments);
        }
        return false;
    }
    
    public function getLocale()
    {
        $s = $this->getServiceLocator()->get('config');
        print_r('ad');
    }
}

