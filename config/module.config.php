<?php
return array(

    'router' => array(
        'routes' => array(
            'product_home' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/product',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Product\Controller',
                        'controller'    => 'Home',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'action'    => 'index',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),

    'console' => array(
        'router' => array(
            'routes' => array(
                'product-menu' => array(
                    'options' => array(
                        'route'    => 'product',
                        'defaults' => array(
                            'controller' => 'Product\Controller\Cli\Menu',
                            'action'     => 'index',
                        ),
                    ),
                ),
                'product-menu-init-database' => array(
                    'options' => array(
                        'route'    => 'product init-database',
                        'defaults' => array(
                            'controller' => 'Product\Controller\Cli\Menu',
                            'action'     => 'initDatabase',
                        ),
                    ),
                ),
            ),
        )
    ),

    'controllers' => array(
        'invokables' => array(
            'Product\Controller\Home' => 'Product\Controller\HomeController',
            'Product\Controller\Cli\Menu' => 'Product\Controller\Cli\MenuController',
        ),
    ),

    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'product/error/404',
        'exception_template'       => 'product/error/index',
        'template_map' => array(
            'product/layout/default'    => __DIR__ . '/../view/product/layout/default.phtml',
            'product/home/index'        => __DIR__ . '/../view/product/home/index.phtml',
            'product/error/404'         => __DIR__ . '/../view/product/error/404.phtml',
            'product/error/index'       => __DIR__ . '/../view/product/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),

    'service_manager' => array(
        'factories' => array(
            'Zend\Db\Adapter\Adapter'
            => 'Zend\Db\Adapter\AdapterServiceFactory',
            'Product\Model\Product\ProductTable'
            => 'Product\Model\Product\ProductTableServiceFactory',
            'Product\Model\Product\ProductTableGateway'
            => 'Product\Model\Product\ProductTableGatewayServiceFactory',
        ),
    ),
);