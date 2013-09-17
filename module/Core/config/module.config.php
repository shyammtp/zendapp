<?php 
return array(
    'controllers' => array(
        'invokables' => array(
            'Core\Controller\Abstract' => 'Core\Controller\AbstractController', 
        ),
    ),
    'di' => array( 
            'Core\Model\Functions' => array(
                'parameters' => array(
                    'adapter'  => 'Zend\Db\Adapter\Adapter',
                ),
            ), 
    ),
);