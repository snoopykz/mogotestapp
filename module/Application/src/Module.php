<?php
/**
 * @link	  http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface
{
	const VERSION = '3.0.3-dev';

	public function getConfig()
	{
		return include __DIR__ . '/../config/module.config.php';
	}

	// public function getControllerConfig()
	// {
	//	 return [
	//		 'factories' => [
	//			 Controller\IndexController::class => function($container) {
	//				 return new Controller\IndexController(
	//					 $container->get(Model\TeamTable::class)
	//				 );
	//			 },
	//		 ],
	//	 ];
	// }

	public function getServiceConfig()
	{
		return [
			'factories' => [
				//  Controller\IndexController::class => function($container) {
				//	 return new Controller\IndexController(
				//		 $container->get(Model\TeamTable::class)
				//	 );
				// },
                Model\TeamTable::class => function($container) {
					$tableGateway = $container->get(Model\TeamTableGateway::class);
					return new Model\TeamTable($tableGateway);
				},
				Model\TeamTableGateway::class => function ($container) {
					$dbAdapter = $container->get(AdapterInterface::class);
					$resultSetPrototype = new ResultSet();
					$resultSetPrototype->setArrayObjectPrototype(new Model\Team());
					return new TableGateway('tb0101_teams', $dbAdapter, null, $resultSetPrototype);
				},
                Model\MatchTable::class => function($container) {
                    $tableGateway = $container->get(Model\MatchTableGateway::class);
                    return new Model\MatchTable($tableGateway);
                },
                Model\MatchTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Match());
                    return new TableGateway('tb0102_matches', $dbAdapter, null, $resultSetPrototype);
                },
                Model\PrePlayOffTable::class => function($container) {
                    $tableGateway = $container->get(Model\PrePlayOffTableGateway::class);
                    return new Model\PrePlayOffTable($tableGateway);
                },
                Model\PrePlayOffTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\PrePlayOff());
                    return new TableGateway('tb0103_playoff', $dbAdapter, null, $resultSetPrototype);
                },
                Model\PlayOffTable::class => function($container) {
                    $tableGateway = $container->get(Model\PlayOffTableGateway::class);
                    return new Model\PlayOffTable($tableGateway);
                },
                Model\PlayOffTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\PlayOff());
                    return new TableGateway('tb0104_playoff', $dbAdapter, null, $resultSetPrototype);
                },
                Model\TournamentFinalTable::class => function($container) {
                    $tableGateway = $container->get(Model\TournamentFinalTableGateway::class);
                    return new Model\TournamentFinalTable($tableGateway);
                },
                Model\TournamentFinalTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\TournamentFinal());
                    return new TableGateway('tb0105_final', $dbAdapter, null, $resultSetPrototype);
                },
			],
		];
	}
}
