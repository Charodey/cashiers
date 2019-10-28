<?php

class cashierOptions
{
	private const PUSH_TIME = 1;
	private const PAY_TIME = 1;
	private const DOWNTIME_FOR_SLEEP = 2;

	public
		$name = 'Cashier',
		$pushTime = null,
		$payTime = null,
		$downtimeForSleep = null;

	public function setDefaultValues()
	{
		$this->name = 'Cashier #' . mt_rand(100, 999); 
		$this->pushTime = static::PUSH_TIME;
		$this->payTime = static::PAY_TIME;
		$this->downtimeForSleep = static::DOWNTIME_FOR_SLEEP;

		return $this;
	}

}
