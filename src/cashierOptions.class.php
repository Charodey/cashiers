<?php

class cashierOptions
{
	private const PUSH_TIME = 1;
	private const PAY_TIME = 1;

	public
		$name = 'Cashier',
		$pushTime = null,
		$payTime = null;

	public function setDefaultValues()
	{
		$this->name = 'Cashier #' . mt_rand(100, 999); 
		$this->pushTime = static::PUSH_TIME;
		$this->payTime = static::PAY_TIME;

		return $this;
	}

}
