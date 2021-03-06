<?php
namespace Admin;
 
use Admin\Model\AdminTable; 
use Admin\Model\Login;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway; 

class Module
{ 
    public function onBootstrap($e)
    {
        $em = $e->getApplication()->getEventManager();
     
        $em->attach(\Zend\Mvc\MvcEvent::EVENT_RENDER, function($e) {
            $flashMessenger = new \Zend\Mvc\Controller\Plugin\FlashMessenger();
            $vm = $e->getViewModel();
            if ($flashMessenger->hasSuccessMessages()) {
               $vm->setVariable('flashSuccessMessages', $flashMessenger->getSuccessMessages());
            }
            if ($flashMessenger->hasErrorMessages()) {
               $vm->setVariable('flashErrorMessages', $flashMessenger->getErrorMessages());
            }
        });
        $sharedEvents = $em->getSharedManager();
        $sharedEvents->attach(__NAMESPACE__, 'dispatch', function($e) {
            $controller = $e->getTarget();
            $route = $controller->getEvent()->getRouteMatch();
                 $e->getViewModel()->setVariables(
            array('controllerName'=> $route->getParam('__CONTROLLER__', 'index'),
                    'actionName' => $route->getParam('action', 'index'),
                    'moduleName' => strtolower(__NAMESPACE__))
            );
           }, 100);
       
    }
    
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
                'Admin\Model\Login\AuthStorage' => function($sm){
                    return new \Admin\Model\Login\AuthStorage('adminOauth');
                },
                'AuthService' => function($sm) {
                    $dbAdapter           = $sm->get('Zend\Db\Adapter\Adapter');
                    $dbTableAuthAdapter  = new DbTableAuthAdapter($dbAdapter, 
                                              'admin_user','username','password', 'MD5(?)');
             
                    $authService = new AuthenticationService();
                    $authService->setAdapter($dbTableAuthAdapter);
                    $authService->setStorage($sm->get('Admin\Model\Login\AuthStorage'));
                    return $authService;
                },
                
            ),
        );
    }
    
    public function getViewHelperConfig()
    {
        return array(
            'invokables' => array(
                'formelementerrors' => 'Admin\Form\View\Helper\FormElementErrors'
            ),
        );
    }
}