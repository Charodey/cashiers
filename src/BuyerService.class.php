<?php

class BuyerService
{
	private const PEAK_BUYERS = 3;
	private const GROWTH_RATE = 0.1;

	private static $prevBuyersCount = 0;
	private static $growthRate = 0;
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
			self::$growthRate = self::$growthRate + static::GROWTH_RATE;
			if (self::$growthRate > 1) {
				self::$growthRate = 1;
			}
			$min = self::$prevBuyersCount;
			$max = round(self::PEAK_BUYERS * self::$growthRate);
			if ($max > self::PEAK_BUYERS) {
				$max = self::PEAK_BUYERS;
			}
		} else {
			self::$growthRate = self::$growthRate - static::GROWTH_RATE;
			if (self::$growthRate < 0) {
				self::$growthRate = 0;
			}
			$min =  round(self::$prevBuyersCount * self::$growthRate);
			$max = self::$prevBuyersCount;
		}
		
		self::$prevBuyersCount = mt_rand($min, $max);
		!self::$behind_peak && self::$behind_peak = (self::$prevBuyersCount >= self::PEAK_BUYERS);
		return self::$prevBuyersCount;
	}

}
