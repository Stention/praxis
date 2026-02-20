<?php

declare(strict_types=1);

namespace App\Router;

use Nette;
use Nette\Application\Responses\RedirectResponse;
use Nette\Application\Routers\RouteList;


final class RouterFactory
{
	use Nette\StaticClass;

	public static function createRouter(): RouteList
	{
		$router = new RouteList;

		// Redirect /home/ na /
		$router->addRoute('home/', function() {
			return new RedirectResponse('/', 301);
		});

		$router->addRoute('<locale cs|en>/home/', function($presenter, $locale) {
			return new RedirectResponse('/' . $locale . '/', 301);
		});

		// Normální routy
		$router->addRoute('[<locale=cs cs|en>/]<presenter>/<action>[/<id>]', [
			'presenter' => 'Home',
			'action' => 'default',
			'locale' => 'cs',
		]);

//		//$router->addRoute('<presenter>/<action>[/<id>]', 'Home:default');
//		$router->addRoute('[<locale=cs cs|en>/]<presenter>/<action>[/<id>]', [
//			'presenter' => 'Home',
//			'action' => 'default',
//			'locale' => 'cs',
//		]);

		return $router;
	}
}
