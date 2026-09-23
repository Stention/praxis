<?php declare(strict_types=1);

namespace App\Presenters;

class ChildStomatologyPresenter extends BaseFrontendPresenter
{
	public function actionDefault(): void
	{
		$locale = $this->getParameter('locale');

		$this->template->title = $locale === 'cs' ?
			'Dětská stomatologie - MDDr. Eliška Kremlová' :
			'Pediatric Dentistry - MDDr. Eliška Kremlová';
		$this->template->metaDescription = $locale === 'cs' ?
			'Dětská stomatologie v centru Prahy – preventivní prohlídky, šetrná léčba zubních kazů, extrakce dočasných zubů a profesionální čištění zubů u dětí.' :
			'Pediatric dentistry in the centre of Prague – preventive check-ups, gentle cavity treatment, primary teeth extraction and professional tooth cleaning for children.';
	}

}
