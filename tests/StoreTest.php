<?php

use PHPUnit\Framework\TestCase;

require 'src/Store.class.php';

class StoreTests extends TestCase
{
	/**
	 * Проверка, что не создатутся лишние кассы.
	 * Лимит касс = 3.
	 */
	public function testCreateCashiers()
	{
		$store = new Store;
		$limit = 3;
		$i = 0;
		while ($i < $limit) {
			$i++;
			$store->createCashier();
		}

		$this->assertEquals($limit, count($store->getCashiers()));
	}

	/**
	 * Проверка, что при наличии свободных касс,
	 * в очередь не встает больше 5 человек
	 */
	public function testQueue()
	{
		$store = new Store;
		$buyersCount = 8;
		$i = 0;
		while ($i < $buyersCount) {
			$i++;
			$buyer = new Buyer;
			$cashier = $store->getBetterCashier();
			$cashier->addBuyer($buyer);
		}

		$cashiers = $store->getCashiers();
		foreach ($cashiers as $cashier) {
			$this->assertEquals(3, $store->getCashiers()[0]->getBuyersCount());
			$this->assertEquals(5, $store->getCashiers()[1]->getBuyersCount());
		}
	}

}
