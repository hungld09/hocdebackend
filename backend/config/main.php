<?php
/**
 * main.php
 *
 * @author: antonio ramirez <antonio@clevertech.biz>
 * Date: 7/22/12
 * Time: 5:48 PM
 *
 * This file holds the configuration settings of your backend application.
 **/
$backendConfigDir = dirname(__FILE__);

$root = $backendConfigDir . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..';

$params = require_once($backendConfigDir . DIRECTORY_SEPARATOR . 'params.php');

// Setup some default path aliases. These alias may vary from projects.
Yii::setPathOfAlias('root', $root);
Yii::setPathOfAlias('common', $root . DIRECTORY_SEPARATOR . 'common');
Yii::setPathOfAlias('backend', $root . DIRECTORY_SEPARATOR . 'backend');
Yii::setPathOfAlias('www', $root. DIRECTORY_SEPARATOR . 'backend' . DIRECTORY_SEPARATOR . 'www');
/* uncomment if you need to use frontend folders */
/* Yii::setPathOfAlias('frontend', $root . DIRECTORY_SEPARATOR . 'frontend'); */


$mainLocalFile = $backendConfigDir . DIRECTORY_SEPARATOR . 'main-local.php';
$mainLocalConfiguration = file_exists($mainLocalFile)? require($mainLocalFile): array();

$mainEnvFile = $backendConfigDir . DIRECTORY_SEPARATOR . 'main-env.php';
$mainEnvConfiguration = file_exists($mainEnvFile) ? require($mainEnvFile) : array();

return CMap::mergeArray(
		array(
				'name' => 'vFilm',
				// @see http://www.yiiframework.com/doc/api/1.1/CApplication#basePath-detail
				'basePath' => 'backend',
				// set parameters
				'params' => $params,
				// preload components required before running applications
				// @see http://www.yiiframework.com/doc/api/1.1/CModule#preload-detail
				'preload' => array('bootstrap', 'log'),
				// @see http://www.yiiframework.com/doc/api/1.1/CApplication#language-detail
				'language' => 'en',
				// using bootstrap theme ? not needed with extension
		'theme' => 'bootstrap',
				// setup import paths aliases
				// @see http://www.yiiframework.com/doc/api/1.1/YiiBase#import-detail
				
				'import' => array(
						'common.components.*',
						'common.extensions.*',
						/* uncomment if required */
						/* 'common.extensions.behaviors.*', */
						/* 'common.extensions.validators.*', */
						'common.models.*',
						// uncomment if behaviors are required
						// you can also import a specific one
						/* 'common.extensions.behaviors.*', */
						// uncomment if validators on common folder are required
						/* 'common.extensions.validators.*', */
						'application.components.*',
						'application.controllers.*',
						'application.models.*',
// 						for modules user & right *** begin
						'application.modules.user.models.*',
						'application.modules.user.components.*',
						'application.modules.rights.*',
						'application.modules.rights.components.*',
						'application.reportmodel.*',
// 						'application.modules.rights.components.dataproviders.*',
// 						for modules user & right *** end
				),
				/* uncomment and set if required */
				// @see http://www.yiiframework.com/doc/api/1.1/CModule#setModules-detail
				'modules' => array(
						'gii' => array(
								'class' => 'system.gii.GiiModule',
								'password' => 'clevertech',
								'generatorPaths' => array(
										'bootstrap.gii'
								)
						),
// 						for modules user & right *** begin
						'user'=>array(
								'tableUsers' => 'users',
								'tableProfiles' => 'profiles',
								'tableProfileFields' => 'profiles_fields',
								
								'hash' => 'md5',
								
								# send activation email
								'sendActivationMail' => true,
								
										# allow access for non-activated users
										'loginNotActiv' => false,
								
										# activate user on registration (only sendActivationMail = false)
										'activeAfterRegister' => false,
								
								# automatically login from registration
												'autoLogin' => true,
								
												# registration path
								'registrationUrl' => array('/user/registration'),
								
												# recovery password path
												'recoveryUrl' => array('/user/recovery'),
								
														# login form path
														'loginUrl' => array('/user/login'),
								
														# page after login
																'returnUrl' => array('/user/profile'),
								
																		# page after logout
																		'returnLogoutUrl' => array('/user/login'),
						),
						
						'rights'=>array(
								'superuserName'=>'Admin', // Name of the role with super user privileges.
								'authenticatedName'=>'Authenticated',  // Name of the authenticated user role.
								'userIdColumn'=>'id', // Name of the user id column in the database.
								'userNameColumn'=>'username',  // Name of the user name column in the database.
								'enableBizRule'=>true,  // Whether to enable authorization item business rules.
								'enableBizRuleData'=>true,   // Whether to enable data for business rules.
								'displayDescription'=>true,  // Whether to use item description instead of name.
								'flashSuccessKey'=>'RightsSuccess', // Key to use for setting success flash messages.
								'flashErrorKey'=>'RightsError', // Key to use for setting error flash messages.
								
								'baseUrl'=>'/rights', // Base URL for Rights. Change if module is nested.
								'layout'=>'rights.views.layouts.main',  // Layout to use for displaying Rights.
								'appLayout'=>'application.views.layouts.main', // Application layout.
								'cssFile'=>'rights.css', // Style sheet file to use for Rights.
								'install'=>false,  // Whether to enable installer.
								'debug'=>false,
						),
// 						for modules user & right *** end
				),
				'components' => array(
						'log'=>array(
								'class'=>'CLogRouter',
								'routes'=>array(
										array(
												'class'=>'CFileLogRoute',
												'levels'=>'error, warning, trace, info',
												'categories'=>'application.*',
										),
						
								),
						),
						
// 						for modules user & right *** begin
						'user'=>array(
								'class'=>'RWebUser',
								// enable cookie-based authentication
								'allowAutoLogin'=>true,
								'loginUrl'=>array('/user/login'),
						),
						'authManager'=>array(
								'class'=>'RDbAuthManager',
								'connectionID'=>'db',
								'defaultRoles'=>array('Authenticated', 'Guest'),
						),
// 						for modules user & right *** end
// 						'user' => array(
// 								'allowAutoLogin'=>true,
// 						),
						/* load bootstrap components */
						'bootstrap' => array(
								'class' => 'common.extensions.bootstrap.components.Bootstrap',
								'responsiveCss' => true,
						),
						'errorHandler' => array(
								// @see http://www.yiiframework.com/doc/api/1.1/CErrorHandler#errorAction-detail
								'errorAction'=>'site/error'
						),
						'db'=> array(
								'connectionString' => $params['db.connectionString'],
								'username' => $params['db.username'],
								'password' => $params['db.password'],
								'schemaCachingDuration' => YII_DEBUG ? 0 : 86400000, // 1000 days
								'enableParamLogging' => YII_DEBUG,
								'charset' => 'utf8'
						),
						'urlManager' => array(
								'urlFormat' => 'path',
								'showScriptName' => false,
								'urlSuffix' => '/',
								'rules' => $params['url.rules']
						),
						/* make sure you have your cache set correctly before uncommenting */
// 						'cache' => $params['cache.core'],
// 						'contentCache' => $params['cache.content']
				),
		),
		CMap::mergeArray($mainEnvConfiguration, $mainLocalConfiguration)
);