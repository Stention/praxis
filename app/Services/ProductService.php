<?php

namespace App\Services;

use Nette\Database\Explorer;
use Nette\Database\Table\ActiveRow;

class ProductService
{
	public function __construct(
		private Explorer $database
	)
	{}

	public function getProductById(int $productId): ?ActiveRow
	{
		return $this->database->table('products')->where('id', $productId)->limit(1)->fetch();
	}

	public function getProductByName(string $productName): ?ActiveRow
	{
		return $this->database->table('products')->where('product_name', $productName)->limit(1)->fetch();
	}

	public function getProducts(): array
	{
		return $this->database->table('products')->fetchAll();
	}

	public function saveProduct(string $productName, string $dentamedUrl, string $dentamedProductCode, string $medplusUrl, string $medplusProductCode, string $image): ?ActiveRow
	{
		return $this->database->table('products')->insert([
			'created' => new \DateTime(),
			'product_name' => $productName,
			'dentamed_url' => $dentamedUrl,
			'dentamed_product_code' => $dentamedProductCode,
			'medplus_url' => $medplusUrl,
			'medplus_product_code' => $medplusProductCode,
			'image' => $image
		]);
	}

	public function savePrices(int $productId, string $partner, float $amount): void
	{
		$this->database->table('prices')->insert([
			'created' => new \DateTime(),
			'product_id' => $productId,
			'partner' => $partner,
			'amount' => $amount,
		]);
	}

}