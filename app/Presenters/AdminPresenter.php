<?php

namespace App\Presenters;

use App\Services\ProductService;
use Nette\Application\AbortException;
use Nette\Application\UI\Form;
use Nette\Application\UI\Presenter;
use Nette;
use Nette\DI\Attributes\Inject;

class AdminPresenter extends Presenter
{
	#[Inject]
	public ProductService $productService;

	/**
	 * @throws AbortException
	 */
	public function startup(): void
	{
		parent::startup();
		$this->setLayout(__DIR__ . '/templates/@admin.layout.latte');

		if (!$this->getUser()->isLoggedIn() && $this->getAction() !== 'login') {
			$this->flashMessage('Pro přístup do této sekce se musíš přihlásit.', 'danger');
			$this->redirect('Admin:login');
		}
	}

	public function actionLogin(): void
	{}

	public function actionDefault(?array $prices = null): void
	{
		$this->template->products = $this->productService->getProducts();

		if ($prices)
			$this->template->prices = $prices;
	}

	protected function createComponentLoginForm(): Form
	{
		$form = new Form;
		$form->addText('username', 'Uživatelské jméno:')
			->setRequired('Prosím vyplňte své uživatelské jméno.');
		$form->addPassword('password', 'Heslo:')
			->setRequired('Prosím vyplňte své heslo.');
		$form->addSubmit('send', 'Přihlásit se');

		$form->onSuccess[] = function (Form $form): void {
			$values = $form->getValues();

			try {
				$this->getUser()->login($values->username, $values->password);
				$this->redirect('Admin:default');

			} catch (Nette\Security\AuthenticationException $e) {
				$form->addError('Nesprávné přihlašovací jméno nebo heslo.');
			}
		};

		return $form;
	}

	protected function createComponentInsertProductForm(): Form
	{
		$form = new Form;
		$form->addText('productName', 'Zadej jméno produktu')->setRequired('Prosím vyplň jméno produktu');
		$form->addText('dentamedUrl', 'Zadej Dentamed URL')->setRequired('Prosím vyplň url');
		$form->addText('medplusUrl', 'Zadej Medplus URL')->setRequired('Prosím vyplň url');
		$form->addSubmit('submit', 'Uložit');

		$form->onSuccess[] = function (Form $form): void {
			$values = $form->getValues();

			$dentamedProductCode = $this->scrape($values->dentamedUrl, 'dentamed');
			$medplusProductCode = $this->scrape($values->medplusUrl,'medplus');

			// Save product
			$this->productService->saveProduct($values->productName, $values->dentamedUrl, $dentamedProductCode, $values->medplusUrl, $medplusProductCode, $values->productName);

			$this->flashMessage('Produkt byl úspěšně uložen.', 'success');
			$this->redirect('Admin:default');
		};

		return $form;
	}

	public function scrape(string $url, string $partner): string
	{
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

		$html = curl_exec($ch);
		curl_close($ch);

		return $partner === 'dentamed' ? $this->extract($html,'manNumber') : str_replace('Kód: ', '', $this->extract($html, 'js-product-catnum'));
	}

	private function extract(string $html, string $class): string
	{
		$dom = new \DOMDocument();
		@$dom->loadHTML($html);
		$xpath = new \DOMXPath($dom);
		$nodes = $xpath->query("//*[contains(@class, '$class')]");

		if ($class === 'js-product-catnum' or $class === 'manNumber')
			return $nodes[0]->textContent;
		else
			return $nodes[1]->getAttribute('content');
	}

	protected function createComponentSearchForPrice(): Form
	{
		$products = $this->productService->getProducts();

		$productList = [0 => 'Zadej jméno produktu'];
		foreach ($products as $product)
			$productList[$product->id] = $product->product_name;

		$form = new Form;
		$form->addSelect('productId', 'Zadej jméno produktu', $productList)->setRequired('Prosím vyplň jméno produktu');
		$form->addSubmit('submit', 'Hledej');

		$form->onSuccess[] = function (Form $form): void {
			$values = $form->getValues();
			$product = $this->productService->getProductById($values->productId);

			$url = 'http://heraldhunt.cz/api/price';

			$data = [
				'dentamed_product_code' => $product->dentamed_product_code,
				'medplus_url' => $product->medplus_url,
			];
			$jsonData = json_encode($data);

			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData); // Send data as URL-encoded
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return the response as a string
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'Content-Type: application/json',
				'Content-Length: ' . strlen($jsonData)
			));

			$response = curl_exec($ch);

			if (str_starts_with($response, '"'))
				$response = substr($response, 1);
			$parts = explode(",", $response);

			$prices = [
				'dentamed_price' => floatval(trim(str_replace(" Kč", "", $parts[0]))),
				'medplus_price' => floatval(trim(str_replace(" Kč", "", $parts[1]))),
			];

			if (curl_errno($ch)) {
				echo 'Error:' . curl_error($ch);
			} else {
				$this->redirect('Admin:default', ['prices' => $prices]);
			}

			curl_close($ch);
		};

		return $form;
	}
}