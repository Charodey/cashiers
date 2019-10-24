<?php

require_once __DIR__ . '/Cashier.class.php';
require_once __DIR__ . '/CashierOptions.class.php';
require_once __DIR__ . '/Buyer.class.php';
require_once __DIR__ . '/BuyerService.class.php';

class Store
{
	private const CASHIERS_COUNT = 3;
	private const WAITING_BUYERS_LIMIT = 5;
	private const WORK_TIME = 8 * 60;

	private $cashiers = [];

	public function __toString()
	{
		$str = '';
		print_r($this->cashiers);

		return $str;
	}

	private function createCashier()
	{
		if (count($this->cashiers) < static::CASHIERS_COUNT) {
			$options = (new CashierOptions())->setDefaultValues();
			$this->cashiers[] = new Cashier($options);
			return true;
		}

		return false;
	}

	public function run()
	{
		$working = true;
		$time = 0;
		echo 'Store doors opening...', PHP_EOL;
		while ($working) {
			$time++;
			echo PHP_EOL, 'time: ', $time, PHP_EOL;

			if ($newBuyers = BuyerService::generateBuyers()) {
				foreach ($newBuyers as $buyer) {
					$cashier = $this->getBetterCashier();
					$cashier->addBuyer($buyer);
				}
			}

			foreach ($this->cashiers as &$cashier) {
				$cashier->timeInc();
			}
			unset($cashier);

			if ($time === 30) {
				$working = false;
			}
			echo 'count newBuyers: ', count($newBuyers), PHP_EOL;
			echo 'count cashiers: ', count($this->cashiers), PHP_EOL;
			foreach ($this->cashiers as $key => $cashier) {
				echo 'all buyers: ', $cashier->getName(), ' ', $cashier->getBuyersCount(). PHP_EOL;
			}
			$time >= static::WORK_TIME && empty($this->cashiers) && $working = false;			
		}
		echo '... door closure', PHP_EOL;
	}

	private function getBetterCashier(): ICashier
	{
		$this->sortBetterCashier();
		if ($this->cashiers && $this->cashiers[0]->getBuyersCount() < static::WAITING_BUYERS_LIMIT) {
			return $this->cashiers[0];
		}

		return $this->createCashier() ? $this->cashiers[count($this->cashiers)-1] : $this->cashiers[0];
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
