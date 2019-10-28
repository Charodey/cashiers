<?php

interface ICashier
{
	public const
		WAKE_STATUS = 2,
		SLEEP_STATUS = 1,
		STARTING_STATUS = 0;

	public function getName(): string;
	public function getStatus();
	public function isSleep(): bool;
	public function addBuyer(Buyer $buyer);
	public function timeInc();
	public function getBuyersCount(): int;
}
