<?php
 
return array(
    'controllers' => array(
        'invokables' => array(
            'Admin\Controller\Admin' => 'Admin\Controller\AdminController',
            'Admin\Controller\Dashboard' => 'Admin\Controller\DashboardController', 
            'Admin\Controller\Settings\General' => 'Admin\Controller\Settings\GeneralController', 
        ),
    ),
    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'admin' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/admin[/][:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Admin',
                        'action'     => 'index',
                    ),
                ),
            ),
            'dashboard' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/admin/dashboard[/][:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Dashboard',
                        'action'     => 'index',
                    ),
                ),
            ),
            'general' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/admin/settings/general[/][:action][/][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Settings\General',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'layout/header'           => __DIR__ . '/../view/admin/common/header.phtml',
            'layout/sidemenu'           => __DIR__ . '/../view/admin/common/sidemenu.phtml',   
            'layout/footer'           => __DIR__ . '/../view/admin/common/footer.phtml',
            'admin/index'               => __DIR__ . '/../view/admin/admin/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            'admin' => __DIR__ . '/../view',
        ),
        'display_not_found_reason' => true, 
        'display_exceptions'       => true,
        'not_found_template'       => 'error/404', 
        'doctype'                  => 'HTML5',
        'exception_template'       => 'error/index',
    ),
    
    'navigation' => array(
        'default' => array(
            array(
                'label' => 'Home',
                'route' => 'home',
            ),
            array(
                'label' => 'Album',
                'route' => 'dashboard',
                /*'pages' => array(
                    array(
                        'label' => 'Add',
                        'route' => 'dashboard',
                        'action' => 'add',
                    ),
                    array(
                        'label' => 'Edit',
                        'route' => 'dashboard',
                        'action' => 'edit',
                    ),
                    array(
                        'label' => 'Delete',
                        'route' => 'dashboard',
                        'action' => 'delete',
                    ),
                ),*/
            ),
        ),
    ),
    'service_manager' => array(
        'factories' => array( 
            'navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',  
        ),
    ),
);