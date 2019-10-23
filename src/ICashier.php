<?php

interface ICashier
{
	public const
		WAKE_STATUS = 'wake',
		SLEEP_STATUS = 'sleep';

	public function getStatus();
	public function wake();
	public function sleep();
	public function getProductTime(): int;
	public function getPayTime(): int;
}
