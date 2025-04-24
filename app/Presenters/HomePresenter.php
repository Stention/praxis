<?php declare(strict_types=1);

namespace App\Presenters;

final class HomePresenter extends BaseFrontendPresenter
{
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
    }

    public function actionDefault(string $language = 'cz'): void
    {
		$this->template->title = $language === 'cz' ?
			'MDDr. Eliška Kremlová - Zubní ordinace' :
			'MDDr. Eliška Kremlová - Dental Clinic';
		$this->template->metaDescription = $language === 'cz' ?
			'Stomatologická péče v příjemném prostředí v centru města' :
			'Dental care in a pleasant environment in the city center';
		$this->template->language = $language;

		$this->template->clinicHours = self::CLINIC_HOURS;
    }
}
