<?php declare(strict_types=1);

namespace App\Presenters;

class PricesPresenter extends BaseFrontendPresenter
{
	const PRICE_LIST = [
		'fotokompozitniVyplnMin' => 2280,
		'fotokompozitniVyplnMax' => 3900,
		'korunkaMetalokeramicka' => 7000,
		'korunkaCelokeramicka' => 9500,
		'dentalniHygiena' => 1800,
		'dentalniHygienaDiteMin' => 960,
		'dentalniHygienaDiteMax' => 1200,
		'vyplnNaDocasnemZubuMin' => 680,
		'vyplnNaDocasnemZubuMax' => 1710,
		'primarniEndodontickeOsetreni' => '3135 - 3990',
		'definitivniPlneni' => '3135 - 3990',
		'konzultace' => 570,
	];

	public function actionDefault(string $language = 'cz'): void
	{
		$this->template->title = $language === 'cz' ?
			'Ceník zubní péče - MDDr. Eliška Kremlová' :
			'Dental Care Pricing - MDDr. Eliška Kremlová';
		$this->template->metaDescription = $language === 'cz' ?
			'Orientační ceník zubních zákroků a ošetření. Přijímáme platby hotově i kartou. Podrobný ceník na vyžádání v ordinaci.' :
			'Overview of dental procedure pricing. Payments accepted in cash or by card. Detailed price list available upon request at the clinic.';
		$this->template->language = $language;

		$this->template->priceList = self::PRICE_LIST;
	}

}