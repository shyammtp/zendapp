<?php
namespace Core\Model;

// Add these import statements
use Zend\Db\TableGateway\TableGateway; 

class Configuration
{ 
    protected $tableGateway;
    protected $_entities;
    
    protected $_configuration = "";

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
        
    }
    
    public function setData($post)
    { 
        $this->fetchEntityPath($post); 
        return $this;
    }
    
    public function getConfigValue($path)
    {
       $select = $this->tableGateway->select(array('path' => $path));
       $result = $select->current();
       return ($result)? $result->value:"";
    }
    
    
    public function setEntity($key, $value)
    {
        if(is_array($key))
        {
            foreach($key as $k => $v)
            {
                $this->_entities[$k] = $v;
            }
        }
        else
        {
             $this->_entities[$key] = $value;
        }
        return $this;
    }
    
    private function checkPathAlready($path = "")
    {
        $select = $this->tableGateway->select(array('path' => $path));
        return $select->count()? true : false;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }
    
    public function save()
    {  
        if(is_array($this->getConfigDatas()))
        {
            foreach($this->getConfigDatas() as $config)
            {
                if($this->checkPathAlready($config['path']))
                {
                    $this->tableGateway->update($config,array('path' => $config['path']));
                }
                else
                {
                    $this->tableGateway->insert($config);
                }
            }
        } 
        return true;
    }
     
    
    private function fetchEntityPath($someArray, $separator = "/")
    {
        $iterator = new \RecursiveIteratorIterator(new \RecursiveArrayIterator($someArray), \RecursiveIteratorIterator::SELF_FIRST);
        $conditionalArray = array();
        foreach ($iterator as $k => $v) {
       
            if (!$iterator->hasChildren()) {
                 
                 for ($p = array(),$v = array(), $i = 0, $z = $iterator->getDepth(); $i <= $z; $i++) {
                        if(!is_numeric( $iterator->getSubIterator($i)->key()))
                        {
                            $p[] = $iterator->getSubIterator($i)->key(); 
                        }
                    } 
                    $path = implode($separator, $p);
                     
                if(is_numeric($k))
                {
                    $value = is_array($iterator->current())?implode(",",$iterator->current()):$iterator->current();
                    $conditionalArray[$path][] =  $value;
                }else{
                    
                     
                    $value = is_array($iterator->current())?implode(",",$iterator->current()):$iterator->current();
                    $outputArray[$path] = $value;
                }
            }
             
        }
        
        $proceduralArray = array();
        foreach($conditionalArray as $key => $array)
        {
            $proceduralArray[$key] = implode(",",$array);
        }
        $final = array_merge($outputArray,$proceduralArray);
        foreach($final as $path => $value)
        {
            $this->_configuration[] = array('path' => $path, 'value'=> $value);
        } 
        return $this->_configuration;
    }
    
    
    
    public function getConfigDatas()
    {
        return $this->_configuration;
    }
  
    public function resetPath()
    {
         $this->_configuration = array();
         return $this->_configuration;
    }
    
 
}