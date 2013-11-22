<?php
namespace Core\Model;
 
use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterAwareInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\TableGateway\TableGateway;
use Zend\Config\Reader\Xml as Xmlreader; 

class Functions 
{
    
    const CONFIG_PATH = 'src/Config/';
    
    protected $_adapter;
    
    protected $_settings = array();
    
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
            $object = new \ReflectionClass($modelClass);
            return $object->newInstanceArgs($arguments);
        }
        return false;
    } 
    
    public function getConfigData($path)
    { 
        $this->getTableGatewayInstance('configuration_set'); 
        $table = new \Core\Model\Configuration($this->_tableGateway); 
        return $table->getConfigValue($path);        
    }
    
    public function readSettings()
    {
        $reader = new Xmlreader();
        foreach(glob('module/*/'.self::CONFIG_PATH.'settings.xml') as $file)
        {
            $data   = $reader->fromFile($file);
            foreach($data as $key => $settings)
            {
                $this->_settings[$key] = $settings;
            } 
        }
        return $this;
    }
    
    public function getSettingForm($index)
    {
        $this->readSettings();
        return isset($this->_settings[$index]) ? $this->_settings[$index] : false;
    } 
    
}

