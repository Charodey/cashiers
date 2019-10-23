<?php

require_once __DIR__ . '/ICashier.php';

class cashier implements ICashier
{
	private const DOWNTIME_FOR_SLEEP = 2;

	private $status = self::SLEEP_STATUS;

	private
		$pushTime = null,
		$payTime = null;

	private
		$downtime = 0,
		$serviceTime = 0;

	function __construct(cashierOptions $options)
	{
		$this->pushTime = $options->pushTime;
		$this->payTime = $options->payTime;
	}

	public function getStatus()
	{
		return $this->status;
	}

	public function wake()
	{
		$this->status = static::WAKE_STATUS;
	}

	public function sleep()
	{
		$this->status = static::SLEEP_STATUS;
	}

	public function getProductTime(): int
	{
		return $this->pushTime;
	}

	public function getPayTime(): int
	{
		return $this->payTime;
	}

	public function addBuyer($buyer)
	{
		$this->downtime = 0;
		$this->buyers[] = $buyer;
	}

	public function timeInc()
	{
		if ($this->buyers) {
			$this->serviceTime++;
			if ($this->serviceTime === ($this->getProductTime() * $this->buyers[0]) + $this->getPayTime()) {
				array_shift($this->buyers);
			}
		} else {
			$this->downtime++;
			$this->checkForSleep();
		}
	}

	private function checkForSleep()
	{
		if (static::DOWNTIME_FOR_SLEEP === $this->downtime) {
			$this->sleep();
		}
	}

	public function getBuyersCount()
	{
		return count($this->buyers);
	}
}
