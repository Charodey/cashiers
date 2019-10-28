<?php

require_once __DIR__ . '/ICashier.php';

class Cashier implements ICashier
{
	private $status = self::STARTING_STATUS;

	private
		$name = null,
		$pushTime = null,
		$payTime = null,
		$downtimeForSleep;

	private
		$downtime = 0,
		$serviceTime = 0;

	private $buyers = [];

	function __construct(cashierOptions $options)
	{
		$this->name = $options->name;
		$this->pushTime = $options->pushTime;
		$this->payTime = $options->payTime;
		$this->downtimeForSleep = $options->downtimeForSleep;
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function getStatus()
	{
		return $this->status;
	}

	public function isSleep(): bool
	{
		return self::SLEEP_STATUS === $this->status;
	}

	private function wake()
	{
		$this->status = static::WAKE_STATUS;
		$this->downtime = 0;
	}

	private function sleep()
	{
		$this->status = static::SLEEP_STATUS;
	}

	private function getProductTime(): int
	{
		return $this->pushTime;
	}

	private function getPayTime(): int
	{
		return $this->payTime;
	}

	public function addBuyer(Buyer $buyer)
	{
		$this->wake();
		$this->buyers[] = $buyer;
	}

	public function timeInc()
	{
		if ($this->buyers) {
			$this->serviceTime++;
			if ($this->serviceTime === $this->getAllTimeForFirstBuyer()) {
				array_shift($this->buyers);
				$this->serviceTime = 0;
			}
		} else {
			$this->downtime++;
			$this->checkForSleep();
		}
	}

	private function getAllTimeForFirstBuyer(): int
	{
		return ($this->getProductTime() * $this->buyers[0]->getProductsCount()) + $this->getPayTime();
	}

	private function checkForSleep()
	{
		if ($this->downtimeForSleep <= $this->downtime) {
			$this->sleep();
		}
	}

	public function getBuyersCount(): int
	{
		return count($this->buyers);
	}
}
