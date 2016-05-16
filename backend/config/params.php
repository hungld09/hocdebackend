<?php
/**
 * params.php
 *
 * @author: antonio ramirez <antonio@clevertech.biz>
 * Date: 7/22/12
 * Time: 1:38 PM
 */
$constFile = $backendConfigDir . DIRECTORY_SEPARATOR . 'const.php';
require($constFile);
$paramsLocalFile = $backendConfigDir . DIRECTORY_SEPARATOR . 'params-local.php';
$paramsLocalFileArray = file_exists($paramsLocalFile) ? require($paramsLocalFile) : array();

$paramsEnvFile = $backendConfigDir . DIRECTORY_SEPARATOR . 'params-env.php';
$paramsEnvFileArray = file_exists($paramsEnvFile) ? require($paramsEnvFile) : array();

$paramsCommonFile = $backendConfigDir . DIRECTORY_SEPARATOR  . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR .
	'common' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'params.php';

$paramsCommonArray = file_exists($paramsCommonFile) ? require($paramsCommonFile) : array();

return CMap::mergeArray(
	$paramsCommonArray,
	// merge frontend specific with resulting env-local merge *override by local
	CMap::mergeArray(
		array(
			'url.format' => 'path',
			'url.showScriptName' => false,
			'url.rules' => array(
				/* for REST please @see http://www.yiiframework.com/wiki/175/how-to-create-a-rest-api/ */
				/* other @see http://www.yiiframework.com/doc/guide/1.1/en/topics.url */
				'<controller:\w+>/<id:\d+>' => '<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
				'<controller:\w+>/<action:\w+>' => '<controller>/<action>',
			),
			// add here all frontend-specific parameters
			'apiServer' => array(
					'url' => 'http://vfilm.vn/api',
// 					'key' => 'vfilm-backend@namviet.vn'
			),
			'serviceNumber' => '1579',
			'smsGateway' => 'http://127.0.0.1:9091/cgi-bin/sendsms?username=vfilm&password=vFilm@2013&to=%s&text=%s',
		),
		// merge environment parameters with local *override by local
		CMap::mergeArray($paramsEnvFileArray, $paramsLocalFileArray)
	)
);