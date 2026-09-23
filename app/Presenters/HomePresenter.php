<?php declare(strict_types=1);

namespace App\Presenters;

final class HomePresenter extends BaseFrontendPresenter
{
	const CLINIC_HOURS = [
		'Monday' => '7:00 – 12:00',
		'Tuesday' => '12:00 – 17:00',
		'Wednesday' => '7:00 – 14:00',
		'Thursday' => null, // by appointment
		'Friday' => '7:00 – 12:00',
	];

    public function startup(): void
    {
        parent::startup();

		$this->setLayout('layout');
    }

    public function actionDefault(): void
    {
		$locale = $this->getParameter('locale');

		$this->template->title = $locale === 'cs' ?
			'MDDr. Eliška Kremlová - Zubní ordinace' :
			'MDDr. Eliška Kremlová - Dental Clinic';
		$this->template->metaDescription = $locale === 'cs' ?
			'Stomatologická péče v příjemném prostředí v centru města' :
			'Dental care in a pleasant environment in the city center';

		$this->template->clinicHours = self::CLINIC_HOURS;
		$this->template->priceList = PricesPresenter::PRICE_LIST;
    }
}
