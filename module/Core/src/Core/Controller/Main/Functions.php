<?php 
namespace Core\Controller\Main; 

use Zend\Db\Sql\Sql;
use Zend\Mvc\Controller\AbstractActionController; 
use Zend\Mvc\Controller\Plugin\FlashMessenger;

class Functions extends AbstractActionController
{
    protected $_sql; 
    
    protected function _getDBAdapter()
    {
        
        return $this->getServiceLocator()->get('Zend_Db_Adapter');
    }
    
    public function getClassInstance($modelClass,$arguments)
    {
        if(''!=$modelClass)
        {
            return new $modelClass($arguments);
        }
        return false;
    }
    
    public function DB()
    {
        if(!$this->_sql)
            $this->_sql = new Sql($this->_getDBAdapter());
        return $this->_sql;
    }
    
    public function getLocale()
    {
        //$s = $this->getServiceLocator()->get('config');
        print_r('ad');
    }
}