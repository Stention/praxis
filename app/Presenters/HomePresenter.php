<?php declare(strict_types=1);

namespace App\Presenters;

use JetBrains\PhpStorm\NoReturn;
use Latte\Essential\RawPhpExtension;
use Nette;
use Nette\Application\AbortException;

//use Nette\Database\Explorer;


final class HomePresenter extends Nette\Application\UI\Presenter
{
    const PRAXIS_NAME = 'Zubní Štěpánská';

    const EMAIL = 'zubni.stepanska@seznam.cz';

    const PHONE = '+420 737 283 401';

    const ADDRESS = 'Štěpánská 55, Praha 1, 110 00';

	const PRICE_LIST = ['fotokompozitniVypln' => 2210,
		'endodontickeOsetreni' => 5850,
		'korunkaMetalokeramicka' => 7000,
		'korunkaCelokeramicka' => 9500,
		];

	const CLINIC_HOURS = '7:00 - 12:30';

	protected function beforeRender(): void
	{
		if (isset($_COOKIE['eu-cookies']) && $_COOKIE['eu-cookies'] === '1') {
			$this->template->cookiesAccepted  = true;
		} else {
			$this->template->cookiesAccepted = false;
		}
	}

    public function startup(): void
    {
        parent::startup();
        $this->setLayout('layout');
        $this->getTemplate()->getLatte()->addExtension(new RawPhpExtension());
    }

    public function actionDefault(): void
    {
        $this->template->praxisName = self::PRAXIS_NAME;
        $this->template->email = self::EMAIL;
        $this->template->phone = self::PHONE;
        $this->template->address = self::ADDRESS;
		$this->template->clinicHours = self::CLINIC_HOURS;

		$this->template->priceList = self::PRICE_LIST;
    }

	/**
	 * @throws AbortException
	 */
	#[NoReturn] public function actionCookie(): void
	{
		setcookie('eu-cookies', '1', time() + 3600 * 24 * 365, '/');

		$this->redirect('Home:default');
	}
}
