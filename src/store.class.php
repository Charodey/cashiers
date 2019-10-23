<?php

ini_set('memory_limit', '512M');

require_once __DIR__ . '/cashier.class.php';
require_once __DIR__ . '/cashierOptions.class.php';

class store
{
	private const PEAK_BUYERS = 50;
	private const CASHIERS_COUNT = 3;
	private const WAITING_BUYERS_LIMIT = 5;
	private const MAX_PRODUCTS_COUNT = 20;
	private const WORK_TIME = 8 * 60;	

	private $cashiers = [];
	private $prevBuyersCount = 0;
	private $behind_peak = false;

	public function __toString()
	{
		$str = '';
		print_r($this->cashiers);

		return $str;
	}

	private function createCashier()
	{
		if (count($this->cashiers) < static::CASHIERS_COUNT) {
			$options = (new cashierOptions())->setDefaultValues();
			$this->cashiers[] = new cashier($options);
			return true;
		}

		return false;
	}

	private function wakeCashier(cashier $cashier)
	{
		$cashier->wake();
	}

	private function sleepCachier(cashier $cashier)
	{
		$cashier->sleep();
	}

	public function run()
	{
		$working = true;
		$time = 0;
		echo 'Store doors opening...', PHP_EOL;
		while ($working) {
			$time++;
			echo PHP_EOL, 'time: ', $time, PHP_EOL;

			if ($newBuyers = $this->generateBuyers()) {
				foreach ($newBuyers as $buyer) {
					$cashier = $this->getBetterCashier();
					$cashier->addBuyer($buyer);
					//unset($cashier);
				}
			}

			foreach ($this->cashiers as &$cashier) {
				$cashier->timeInc();
			}
			unset($cashier);

			if ($time === 5) {
				$working = false;
			}
			echo 'count newBuyers: ', count($newBuyers), PHP_EOL;
			echo 'count cashiers: ', count($this->cashiers), PHP_EOL;
			foreach ($this->cashiers as $key => $cashier) {
				echo 'all buyers #', $key, ' ', $cashier->getBuyersCount(). PHP_EOL;
			}
			$time >= static::WORK_TIME && empty($this->cashiers) && $working = false;			
		}
		echo '... door closure', PHP_EOL;
	}

	private function &getBetterCashier()
	{
		$this->sortByWaitingBuyers();
		if ($this->cashiers && $this->cashiers[0]->getBuyersCount() < static::WAITING_BUYERS_LIMIT) {
			return $this->cashiers[0];
		}

		return $this->createCashier() ? $this->cashiers[count($this->cashiers)-1] : $this->cashiers[0];
	}

	private function sortByWaitingBuyers()
	{
		if ($this->cashiers) {
			foreach ($this->cashiers as $key => $cashier) {
				$buyersCount[$key] = $cashier->getBuyersCount();
			}
			array_multisort($buyersCount, SORT_ASC, $this->cashiers);
		}
	}

	private function generateBuyers()
	{
		$newBuyers = [];
		$i = 0;
		$count = $this->generateBuyersCount();
		while ($i < $count) {
			$i++;
			$buyer = new User();
			$buyer->productsCount = mt_rand(1, static::MAX_PRODUCTS_COUNT);
			$newBuyers[] = $buyer;
		}

		return $newBuyers;
	}

	private function generateBuyersCount()
	{
		if (!$this->behind_peak) {
			$min = $this->prevBuyersCount;
			$max = (int)static::PEAK_BUYERS;
		} else {
			$min = 0;
			$max = $this->prevBuyersCount;
		}
		
		$this->prevBuyersCount = mt_rand($min, $max);
		!$this->behind_peak && $this->behind_peak = ($this->prevBuyersCount === static::PEAK_BUYERS);
		return $this->prevBuyersCount;
	}

}

class User
{
	public $productsCount = 0;
}
