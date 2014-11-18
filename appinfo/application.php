<?php
/**
 * ownCloud - bav
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Claus-Justus Heine <himself@claus-justus-heine.de>
 * @copyright Claus-Justus Heine 2014
 */

namespace OCA\TestApp\AppInfo;


use \OCP\AppFramework\App;

use \OCA\TestApp\Controller\PageController;


class Application extends App {


	public function __construct (array $urlParams=array()) {
		parent::__construct('bav', $urlParams);

		$container = $this->getContainer();

		/**
		 * Controllers
		 */
		$container->registerService('PageController', function($c) {
			return new PageController(
				$c->query('AppName'), 
				$c->query('Request'),
				$c->query('UserBlahId')
			);
		});


		/**
		 * Core
		 */
		$container->registerService('UserBlahId', function($c) {
			return \OCP\User::getUser()."blah";
		});		
		
	}


}