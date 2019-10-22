<?php

require_once __DIR__ . '/ICashier.php';

class cashier implements ICashier
{
	private $status = self::SLEEP_STATUS;

	private
		$pushTime = null,
		$payTime = null;

	function __construct(cashierOptions $options)
	{
		static::$pushTime = $options->pushTime;
		static::$payTime = $options->payTime;
	}

	public function getStatus()
	{
		return static::$status;
	}

	public function wake()
	{
		$this->status = static::WAKE_STATUS;
	}

	public function sleep()
	{
		$this->status = static::SLEEP_STATUS;
	}

	public function getPunchTime(): int
	{
		return $this->pushTime;
	}

	public function getPayTime(): int
	{
		return $this->payTime;
	}

}
