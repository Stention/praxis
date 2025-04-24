<?php declare(strict_types=1);

namespace App\Presenters;

class CertificatesPresenter extends BaseFrontendPresenter
{
	public function actionDefault(string $language = 'cz'): void
	{
		$this->template->title = $language === 'cz' ?
			'Diplomy a certifikace - MDDr. Eliška Kremlová' :
			'Diplomas and Certifications - MDDr. Eliška Kremlová';
		$this->template->metaDescription = $language === 'cz' ?
			'Přehled certifikátů a diplomů MDDr. Elišky Kremlové, které potvrzují odborné vzdělání a kvalifikaci v oblasti stomatologie.' :
			'An overview of diplomas and certifications of MDDr. Eliška Kremlová, confirming professional education and qualifications in the field of dentistry.';;
		$this->template->language = $language;
	}

}