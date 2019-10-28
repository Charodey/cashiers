<?php

require_once __DIR__ . '/Cashier.class.php';
require_once __DIR__ . '/CashierOptions.class.php';
require_once __DIR__ . '/Buyer.class.php';
require_once __DIR__ . '/BuyerService.class.php';

class Store
{
	private const CASHIERS_COUNT = 3;
	private const WAITING_BUYERS_LIMIT = 5;
	private const WORK_TIME = 8 * 3600;

	private $cashiers = [];

	public function run()
	{
		$working = true;
		$time = 0;
		echo 'Store doors opening...', PHP_EOL;
		while ($working) {
			$time++;

			if ($newBuyers = BuyerService::generateBuyers($time, static::WORK_TIME)) {
				foreach ($newBuyers as $buyer) {
					$cashier = $this->getBetterCashier();
					$cashier->addBuyer($buyer);
				}
			}

			foreach ($this->cashiers as &$cashier) {
				$cashier->timeInc();
			}
			unset($cashier);

			$this->removeSleepingCashiers();

			if ($time % 3600 === 0) {
				$this->printData($time);
			}

			$time >= static::WORK_TIME && empty($this->cashiers) && $working = false;			
		}

		echo '... door closure', PHP_EOL;
	}

	private function printData($time)
	{
		echo PHP_EOL, 'Hour: ', $time/3600, PHP_EOL;
		echo 'Cashiers count: ', count($this->cashiers), PHP_EOL;
		foreach ($this->cashiers as $cashier) {
			echo 'Buyers count on cashier: ', $cashier->getBuyersCount(), PHP_EOL;
		}
	}

	public function createCashier()
	{
		if (count($this->cashiers) < static::CASHIERS_COUNT) {
			$options = (new CashierOptions())->setDefaultValues();
			$this->cashiers[] = new Cashier($options);
			$this->cashiers = array_values($this->cashiers);
			return true;
		}

		return false;
	}

	public function getCashiers()
	{
		return $this->cashiers;
	}

	private function removeSleepingCashiers()
	{
		foreach ($this->cashiers as $key => $cashier) {
			if ($cashier->isSleep()) {
				unset($this->cashiers[$key]);
			}
		}
	}

	public function getBetterCashier(): ICashier
	{
		$this->sortBetterCashier();
		if ($this->cashiers && $this->cashiers[0]->getBuyersCount() < static::WAITING_BUYERS_LIMIT) {
			return $this->cashiers[0];
		}

		return $this->createCashier()
			? $this->cashiers[count($this->cashiers)-1]
			: $this->cashiers[0];
	}

	private function sortBetterCashier()
	{
		if ($this->cashiers) {
			foreach ($this->cashiers as $key => $cashier) {
				$cashierStatus[$key] = $cashier->getStatus();
				$buyersCount[$key] = $cashier->getBuyersCount();
			}
			array_multisort($cashierStatus, SORT_DESC, $buyersCount, SORT_ASC, $this->cashiers);
		}
	}

}
