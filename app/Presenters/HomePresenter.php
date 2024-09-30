<?php declare(strict_types=1);

namespace App\Presenters;

use Latte\Essential\RawPhpExtension;
use Nette\Application\UI\Presenter;

//use Nette\Database\Explorer;

final class HomePresenter extends Presenter
{
    const PRAXIS_NAME = 'Zubní Štěpánská';

    const EMAIL = 'zubni.stepanska@seznam.cz';

    const PHONE = '+420 737 283 401';

    const ADDRESS = 'Štěpánská 55, Praha 1, 110 00';

	const PRICE_LIST = ['fotokompozitniVypln' => 2210,
		'endodontickeOsetreni' => 5850,
		'korunkaMetalokeramicka' => 7000,
		'korunkaCelokeramicka' => 9500,
		'dentalniHygiena' => 1800,
		];

	const CLINIC_HOURS = [
		'Monday' => '7:30 – 13:45',
		'Wednesday' => '7:30 – 13:30',
		'Thursday' => '7:00 - 13:00 / 12:00 - 17:00',
		'Friday' => '7:30 – 13:45',
	];

    public function startup(): void
    {
        parent::startup();

		$this->setLayout('layout');
        $this->getTemplate()->getLatte()->addExtension(new RawPhpExtension());
    }

	public function renderDefault(): void
	{
		$cookiesAccepted = $this->getHttpRequest()->getCookie('accept_ZS_cookies');
		$this->template->cookiesAccepted = $cookiesAccepted === 'true';
	}

    public function actionDefault(string $language = 'cz'): void
    {
		$this->template->language = $language;
        $this->template->praxisName = self::PRAXIS_NAME;
        $this->template->email = self::EMAIL;
        $this->template->phone = self::PHONE;
        $this->template->address = self::ADDRESS;
		$this->template->clinicHours = self::CLINIC_HOURS;
		$this->template->priceList = self::PRICE_LIST;
    }
}
