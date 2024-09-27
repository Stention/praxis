<?php

namespace App\Presenters;

use App\Services\ProductService;
use JetBrains\PhpStorm\NoReturn;
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

	public function actionDefault(?int $productId = null): void
	{
		$this->template->products = $this->productService->getProducts();

		if ($productId) {
			$product = $this->productService->getProductById($productId);
			$this->template->prices = $product->related('prices');
		} else {
			$this->template->prices = null;
		}
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

			[$dentamedProductCode, $dentamedPrice] = $this->scrape($values->dentamedUrl, 'dentamed');
			[$medplusProductCode, $medplusPrice] = $this->scrape($values->medplusUrl,'medplus');

			// Save product
			$product = $this->productService->saveProduct($values->productName, $values->dentamedUrl, $dentamedProductCode, $values->medplusUrl, $medplusProductCode, $values->productName);

			// Save prices
			$this->productService->savePrices($product->id, 'dentamed', (float) $dentamedPrice);
			$this->productService->savePrices($product->id, 'medplus', (float) $medplusPrice);

			$this->flashMessage('Produkt byl úspěšně uložen.', 'success');
			$this->redirect('Admin:default');
		};

		return $form;
	}

	public function scrape(string $url, string $partner): array
	{
		$html = $this->fetchHtml($url);

		if ($partner === 'dentamed') {
			//$this->saveImages($html);
			$productCode = $this->extract($html,'@class', 'manNumber');
			$price = $this->extract($html, '@class', 'price');
		} else {
			//$this->saveImages($html);
			$productCode = $this->extract($html, '@itemprop', 'sku');
			$price = $this->extract($html, '@itemprop', 'price');
		}

		return [$productCode, $price];
	}

	private function saveImages(string $html): void
	{
		$imagesDir = __DIR__ . '/../../www/img/products';
		if (!is_dir($imagesDir))
			mkdir($imagesDir, 0777, true);

		preg_match_all('/<img[^>]+src="([^">]+)"/i', $html, $matches);

		foreach ($matches[1] as $src)
			if (filter_var($src, FILTER_VALIDATE_URL)) {
				$imageContent = file_get_contents($src);
				$imageName = basename($src);
				file_put_contents($imagesDir . '/' . $imageName, $imageContent);
			}
	}

	private function extract(string $html, string $tag, string $class): string
	{
		$dom = new \DOMDocument();
		@$dom->loadHTML($html);
		$xpath = new \DOMXPath($dom);
		$nodes = $xpath->query("//*[contains($tag, '$class')]");

		if ($class === 'sku' or $class === 'manNumber')
			return $nodes[0]->textContent;
		else
			return $nodes[1]->getAttribute('content');
		}

	private function fetchHtml(string $url): string
	{
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

		$html = curl_exec($ch);
		curl_close($ch);

		return $html;
	}

	protected function createComponentSearchForPrice(): Form
	{
		$form = new Form;
		$form->addText('productName', 'Zadej jméno produktu')->setRequired('Prosím vyplň jméno produktu');
		$form->addSubmit('submit', 'Hledej');

		$form->onSuccess[] = function (Form $form): void {
			$values = $form->getValues();
			$product = $this->productService->getProductByName($values->productName);

			$this->redirect('Admin:default', ['productId' => $product->id]);
		};

		return $form;
	}
}