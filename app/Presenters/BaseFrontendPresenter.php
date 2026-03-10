<?php declare(strict_types=1);

namespace App\Presenters;

use Nette\Application\UI\Presenter;

class BaseFrontendPresenter extends Presenter
{

	const PRAXIS_NAME = 'Zubní Štěpánská';

	const EMAIL = 'zubni.stepanska@seznam.cz';

	const PHONE = '+420 737 283 401';

	const ADDRESS = 'Štěpánská 55, Praha 1, 110 00';

	const CANONICAL_BASE = 'https://www.zubni-stepanska.cz';

	public function beforeRender(): void
	{
		parent::beforeRender();

		$locale = $this->getParameter('locale') ?? 'cs';
		$this->template->locale = $locale;

		$presenter = $this->getName();
		$action = $this->getAction();
		$params = $this->getParameters();

		// Canonical - vždy používá pevnou HTTPS doménu, nikoliv dynamické schéma z requestu
		$canonicalPath = $this->link($presenter . ':' . $action, $params);
		$this->template->canonicalUrl = self::CANONICAL_BASE . $canonicalPath;

		// Hreflang CS - stejná stránka bez locale parametru (= výchozí cs)
		$paramsCs = $params;
		unset($paramsCs['locale']);
		$hreflangCsPath = $this->link($presenter . ':' . $action, $paramsCs);
		$this->template->hreflangCs = self::CANONICAL_BASE . $hreflangCsPath;

		// Hreflang EN - stejná stránka s locale=en
		$paramsEn = $params;
		$paramsEn['locale'] = 'en';
		$hreflangEnPath = $this->link($presenter . ':' . $action, $paramsEn);
		$this->template->hreflangEn = self::CANONICAL_BASE . $hreflangEnPath;
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