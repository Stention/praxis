<?php declare(strict_types=1);

namespace App\Presenters;

class InsurancePresenter extends BaseFrontendPresenter
{
	public function actionDefault(): void
	{
		$locale = $this->getParameter('locale');

		$this->template->title = $locale === 'cs' ?
			'Smluvní pojišťovny - MDDr. Eliška Kremlová' :
			'Insurance Providers - MDDr. Eliška Kremlová';
		$this->template->metaDescription = $locale === 'cs' ?
			'Spolupracujeme s hlavními českými zdravotními pojišťovnami – VZP, VoZP, OZP, ZPMV a ČPZP. Kvalitní stomatologická péče hrazená pojišťovnou.' :
			'We cooperate with major Czech health insurance companies including VZP, VoZP, OZP, ZPMV, and ČPZP. Quality dental care with insurance coverage.';
	}

}