<?php declare(strict_types=1);

namespace App\Presenters;

use Latte\Essential\RawPhpExtension;
use Nette\Application\UI\Presenter;

final class HomePresenter extends Presenter
{
    const PRAXIS_NAME = 'Zubní Štěpánská';

    const EMAIL = 'zubni.stepanska@seznam.cz';

    const PHONE = '+420 737 283 401';

    const ADDRESS = 'Štěpánská 55, Praha 1, 110 00';

	const PRICE_LIST = [
		'fotokompozitniVypln' => 2210,
		'endodontickeOsetreni' => 5850,
		'korunkaMetalokeramicka' => 7000,
		'korunkaCelokeramicka' => 9500,
		'dentalniHygiena' => 1800,
		];

	const CLINIC_HOURS = [
		'Monday' => '7:00 – 12:00',
		'Tuesday' => '7:30 – 12:30',
		'Wednesday' => '7:30 – 15:00',
		'Thursday' => '7:00 - 13:00 / 12:00 - 17:00',
		'Friday' => '7:00 – 12:00',
	];

    public function startup(): void
    {
        parent::startup();

		$this->setLayout('layout');
        $this->getTemplate()->getLatte()->addExtension(new RawPhpExtension());

		$cookiesAccepted = false;
		$cookiesAcceptedValue = $this->getHttpRequest()->getCookie('accept_ZS_cookies');
		if ($cookiesAcceptedValue === 'true')
			$cookiesAccepted = true;

		$this->template->cookiesAccepted = $cookiesAccepted;
    }

	public function renderDefault(): void
	{}

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
