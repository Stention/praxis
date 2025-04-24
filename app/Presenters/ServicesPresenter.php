<?php declare(strict_types=1);

namespace App\Presenters;

class ServicesPresenter extends BaseFrontendPresenter
{
	public function actionDefault(string $language = 'cz'): void
	{
		$this->template->title = $language === 'cz' ?
			'Zubní služby - MDDr. Eliška Kremlová' :
			'Dental Services - MDDr. Eliška Kremlová';
		$this->template->metaDescription = $language === 'cz' ?
			'Komplexní stomatologická péče – konzervativní ošetření, dentální hygiena, endodoncie, protetika, estetická stomatologie a péče o dětské pacienty.' :
			'Comprehensive dental care – conservative treatment, dental hygiene, endodontics, prosthetics, aesthetic dentistry, and care for children.';
		$this->template->language = $language;
	}
}