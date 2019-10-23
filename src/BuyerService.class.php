<?php

class BuyerService
{
	private const PEAK_BUYERS = 50;

	private static $prevBuyersCount = 0;
	private static $behind_peak = false;

	public static function generateBuyers()
	{
		$newBuyers = [];
		$i = 0;
		$count = self::generateBuyersCount();
		while ($i < $count) {
			$i++;
			$newBuyers[] = new Buyer();
		}

		return $newBuyers;
	}

	private static function generateBuyersCount(): int
	{
		if (!self::$behind_peak) {
			$min = self::$prevBuyersCount;
			$max = self::PEAK_BUYERS;
		} else {
			$min = 0;
			$max = self::$prevBuyersCount;
		}
		
		self::$prevBuyersCount = mt_rand($min, $max);
		!self::$behind_peak && self::$behind_peak = (self::$prevBuyersCount === self::PEAK_BUYERS);
		return self::$prevBuyersCount;
	}

}
