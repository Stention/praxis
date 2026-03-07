<?php declare(strict_types=1);

namespace App\Presenters;

use Nette\Application\UI\Presenter;

class BaseFrontendPresenter extends Presenter
{

	const PRAXIS_NAME = 'Zubní Štěpánská';

	const EMAIL = 'zubni.stepanska@seznam.cz';

	const PHONE = '+420 737 283 401';

	const ADDRESS = 'Štěpánská 55, Praha 1, 110 00';

	public function beforeRender(): void
	{
		parent::beforeRender();

		$locale = $this->getParameter('locale') ?? 'cs';
		$this->template->locale = $locale;

		// Vygeneruj canonical URL s explicitními parametry
		$presenter = $this->getName();
		$action = $this->getAction();
		$params = $this->getParameters();

		// Canonical - aktuální stránka s aktuální locale
		$canonical = $this->link('//' . $presenter . ':' . $action, $params);
		// Normalizuj velká písmena
		$canonical = preg_replace_callback('/\/([A-Z][a-z]+)/', function($matches) {
			return '/' . lcfirst($matches[1]);
		}, $canonical);
		$this->template->canonicalUrl = $canonical;

		// Hreflang CS - stejná stránka, ale bez locale (= cs)
		$paramsCs = $params;
		unset($paramsCs['locale']); // Odstranit locale = použije se default cs
		$hreflangCs = $this->link('//' . $presenter . ':' . $action, $paramsCs);
		$hreflangCs = preg_replace_callback('/\/([A-Z][a-z]+)/', function($matches) {
			return '/' . lcfirst($matches[1]);
		}, $hreflangCs);

		// Hreflang EN - stejná stránka s locale=en
		$paramsEn = $params;
		$paramsEn['locale'] = 'en';
		$hreflangEn = $this->link('//' . $presenter . ':' . $action, $paramsEn);
		$hreflangEn = preg_replace_callback('/\/([A-Z][a-z]+)/', function($matches) {
			return '/' . lcfirst($matches[1]);
		}, $hreflangEn);

		$this->template->hreflangCs = $hreflangCs;
		$this->template->hreflangEn = $hreflangEn;
	}

	public function startup(): void
	{
		parent::startup();

		$httpRequest = $this->getHttpRequest();
		$language = $httpRequest->getQuery('language');

		if ($language === 'en') {
			$params = $this->getParameters();
			$params['locale'] = 'en';
			unset($params['language']);
			$this->redirectPermanent($this->getName() . ':' . $this->getAction(), $params);
		}

		if ($language === 'cs') {
			$params = $this->getParameters();
			unset($params['locale']);
			unset($params['language']);
			$this->redirectPermanent($this->getName() . ':' . $this->getAction(), $params);
		}

		$locale = $this->getParameter('locale') ?? 'cs';
		$this->template->locale = $locale;

		$this->setLayout('layout');

		$this->template->praxisName = self::PRAXIS_NAME;
		$this->template->email = self::EMAIL;
		$this->template->phone = self::PHONE;
		$this->template->address = self::ADDRESS;
	}
}