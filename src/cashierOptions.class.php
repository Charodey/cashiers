<?php

class cashierOptions
{
	private const PUSH_TIME = 5;
	private const PAY_TIME = 12;

	public
		$pushTime = null,
		$payTime = null;

	public function setDefaultValues()
	{
		$this->pushTime = static::PUSH_TIME;
		$this->payTime = static::PAY_TIME;

		return $this;
	}

}
