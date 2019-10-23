<?php

interface ICashier
{
	public const
		WAKE_STATUS = 1,
		SLEEP_STATUS = 0;

	public function getStatus();
	//public function wake();
	//public function sleep();
	//public function getProductTime(): int;
	//public function getPayTime(): int;
}
