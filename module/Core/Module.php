<?php
namespace Core;

use Core\Model\Functions;
use Core\Model\Country as CountryRegion;    
use Core\Model\Configuration;
use Zend\Db\TableGateway\TableGateway; 
class Module
{ 
    
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
    public function getAutoloaderConfig()
    {
         return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    // Add this method:
    public function getServiceConfig()
    {
        return array(
            'factories' => array( 
                'Zend_Db_Adapter' =>  function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter'); 
                    return $dbAdapter;
                },
                'Core\Model\Country' =>  function($sm) {
                    $tableGateway = $sm->get('countryGateway');
                    $table = new CountryRegion($tableGateway); 
                    return $table;
                },
                'countryGateway' => function($sm){
                    $dbAdapter = $sm->get('Zend_Db_Adapter'); 
                    return new TableGateway('country_region', $dbAdapter);
                },
                'Core\Model\Configuration' => function($sm)
                {
                    $dbAdapter = $sm->get('Zend_Db_Adapter'); 
                    $tableGateway = new TableGateway('configuration_set', $dbAdapter);
                    $table = new Configuration($tableGateway); 
                    return $table;
                }
            ),
        );
    }
     
}