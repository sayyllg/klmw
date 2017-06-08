<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Ehr;

return array(
	'controllers' => array(
		'invokables' => array(
			'Ehr\Controller\Index'      => 'Ehr\Controller\IndexController',
			'Ehr\Controller\User'       => 'Ehr\Controller\UserController',
			'Ehr\Controller\Account'       => 'Ehr\Controller\AccountController',
			'Ehr\Controller\Lg'       => 'Ehr\Controller\LgController',
			),
	),
	'router' => array(
		'routes' => array(
			
			// The following is a route to simplify getting started creating
			// new controllers and actions without needing to create a new
			// module. Simply drop new controllers in, and you can access them
			// using the path /application/:controller/:action
			'ehr' => array(
				'type'    => 'Segment',
				'options' => array(
					'route'    => '/[:controller[/:action]][/]',
					'constraints' => array(
								'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
								'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
							),
					'defaults' => array(
						'__NAMESPACE__' => 'Ehr\Controller',
						'controller'    => 'Index',
						'action'        => 'index',
					),
				),
				
			),
		),
	),
	'service_manager' => array(
		'abstract_factories' => array(
			'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
			'Zend\Log\LoggerAbstractServiceFactory',
		),
		'factories' => array(
			'translator' => 'Zend\Mvc\Service\TranslatorServiceFactory',
		),
	),
	'translator' => array(
		'locale' => 'en_US',
		'translation_file_patterns' => array(
			array(
				'type'     => 'gettext',
				'base_dir' => __DIR__ . '/../language',
				'pattern'  => '%s.mo',
			),
		),
	),
   
	'view_manager' => array(
		'display_not_found_reason' => true,
		'display_exceptions'       => true,
		'doctype'                  => 'HTML5',
		'not_found_template'       => 'error/404',
		'exception_template'       => 'error/index',
		'template_map' => array(
			'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
			'ehr/index/index' => __DIR__ . '/../view/ehr/index/index.phtml',
			'error/404'               => __DIR__ . '/../view/error/404.phtml',
			'error/index'             => __DIR__ . '/../view/error/index.phtml',
			'Account/index'             => __DIR__ . '/../view/Account/index.phtml',
		),
		'template_path_stack' => array(
			__DIR__ . '/../view',
		),
	),
	// Placeholder for console routes
	'console' => array(
		'router' => array(
			'routes' => array(
			),
		),
	),
);
