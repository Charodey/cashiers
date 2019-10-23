<?php

class Buyer
{
	private const MAX_PRODUCTS_COUNT = 20;

	private $productsCount = 0;

	function __construct()
	{
		$this->productsCount = mt_rand(1, static::MAX_PRODUCTS_COUNT);
	}

	public function getProductsCount(): int
	{
		return $this->productsCount;
	}

}
