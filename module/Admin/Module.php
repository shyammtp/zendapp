<?php
namespace Admin;
 
use Admin\Model\AdminTable;
use Admin\Model\Login;
use Zend\Db\ResultSet\ResultSet;
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
                'Admin\Model\AdminTable' =>  function($sm) {
                    $tableGateway = $sm->get('AdminTableGateway');
                    $table = new AdminTable($tableGateway); 
                    return $table;
                },
                'AdminTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Login());
                    return new TableGateway('admin_user', $dbAdapter, null, $resultSetPrototype);
                },
                'Admin\Model\Login' =>  function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $admin = new Login();
                    $admin->setDbAdapter($dbAdapter);
                    return $admin;
                },
            ),
        );
    }
}