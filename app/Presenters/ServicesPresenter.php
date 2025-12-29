<?php declare(strict_types=1);

namespace App\Presenters;

class ServicesPresenter extends BaseFrontendPresenter
{
	public function actionDefault(): void
	{
		$locale = $this->getParameter('locale');

		$this->template->title = $locale === 'cs' ?
			'Zubní služby - MDDr. Eliška Kremlová' :
			'Dental Services - MDDr. Eliška Kremlová';
		$this->template->metaDescription = $locale === 'cs' ?
			'Komplexní stomatologická péče – konzervativní ošetření, dentální hygiena, endodoncie, protetika, estetická stomatologie a péče o dětské pacienty.' :
			'Comprehensive dental care – conservative treatment, dental hygiene, endodontics, prosthetics, aesthetic dentistry, and care for children.';
	}
}