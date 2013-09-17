<?php
namespace Core\Model;
 
use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterAwareInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\TableGateway\TableGateway;  

class Functions 
{  
    protected $_adapter;
    
    protected $_tableGateway;
    
    protected $serviceLocator;
    
    public function __construct()
    {
        $this->setDbAdapter();
    }
    
    public function setDbAdapter()
    {
        if(!$this->_adapter)
        {
            $configArray = require 'config/autoload/database.local.php'; 
            $this->_adapter = new Adapter($configArray['db']);
        }
        return $this;
    }
     
    public function getDBAdapter()
    { 
        return $this->_adapter;
    } 
     
    public function getTableGatewayInstance($table="")
    {
        if(!$this->_tableGateway)
            $this->_tableGateway = new TableGateway($table, $this->_adapter);
        return $this->_tableGateway;
    }
    
    public function getClassInstance($modelClass,$arguments)
    {
        if(''!=$modelClass)
        {
            return new $modelClass($arguments);
        }
        return false;
    } 
    
    public function getConfigData($path)
    { 
        $this->getTableGatewayInstance('configuration_set'); 
        $table = new \Core\Model\Configuration($this->_tableGateway); 
        return $table->getConfigValue($path);        
    }
}

