<?php

require_once __DIR__ . '/cashier.class.php';
require_once __DIR__ . '/cashierOptions.class.php';

class store
{
	private const PEAK_BUYERS = MAX_BUYERS ?? 50;
	private const CASHIERS_LIMIT = CASHIERS_LIMIT ?? 3;

	private $cashiers = [];
	private $prevBuyersCount = 0;
	private $behind_peak = false;

	private function createCashier()
	{
		if (count(static::$cashiers < static::CASHIERS_LIMIT)) {
			$options = (new cashierOptions())->setDefaultValues();
			static::$cashiers[] = new cashier($options);
		}
	}

	private function wakeCashier(cashier $cashier)
	{
		$cashier->wake();
	}

	private function sleepCachier(cashier $cashier)
	{
		$cashier->sleep();
	}

	private function generateBuyersCount()
	{
		if (!$this->behind_peak) {
			$min = $this->prevBuyersCount;
			$max = static::MAX_BUYERS;
		} else {
			$min = 0;
			$max = $this->prevBuyersCount;
		}
		
		$this->prevBuyersCount = mt_rand($min, $max);
		!$this->behind_peak && $this->behind_peak = ($this->prevBuyersCount === static::PEAK_BUYERS);
		return $this->prevBuyersCount;
	}

}
