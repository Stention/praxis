<?php

namespace App\Presenters;

class ChildStomatologyPresenter extends BaseFrontendPresenter
{
	public function actionDefault(): void
	{
		$locale = $this->getParameter('locale');

		$this->template->title = $locale === 'cs' ?
			'Diplomy a certifikace - MDDr. Eliška Kremlová' :
			'Diplomas and Certifications - MDDr. Eliška Kremlová';
		$this->template->metaDescription = $locale === 'cs' ?
			'Přehled certifikátů a diplomů MDDr. Elišky Kremlové, které potvrzují odborné vzdělání a kvalifikaci v oblasti stomatologie.' :
			'An overview of diplomas and certifications of MDDr. Eliška Kremlová, confirming professional education and qualifications in the field of dentistry.';;
	}

}