<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'FMS\Controller\Index' => 'FMS\Controller\IndexController',
        ),
    ),
    
     // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'FMS-index' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/api-evr/fms[/:action][/:id]',
		      'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                     ),
                      'defaults' => array(
                        'controller' => 'FMS\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
    
    'view_manager' => array(
        'exception_template'       => 'error/index',
        'template_map' => array(
        	'layout' => __DIR__ . '/../view/layout/layout.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
        'display_not_found_reason' => true,
        'display_exceptions' => true,
    ),
);

?>
