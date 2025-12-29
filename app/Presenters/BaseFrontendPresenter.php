<?php declare(strict_types=1);

namespace App\Presenters;

use Nette\Application\UI\Presenter;

class BaseFrontendPresenter extends Presenter
{

	const PRAXIS_NAME = 'Zubní Štěpánská';

	const EMAIL = 'zubni.stepanska@seznam.cz';

	const PHONE = '+420 737 283 401';

	const ADDRESS = 'Štěpánská 55, Praha 1, 110 00';

	public function startup(): void
	{
		parent::startup();

		$locale = $this->getParameter('locale');
		$this->template->locale = $locale;

		$this->setLayout('layout');

		$this->template->praxisName = self::PRAXIS_NAME;
		$this->template->email = self::EMAIL;
		$this->template->phone = self::PHONE;
		$this->template->address = self::ADDRESS;
	}
}