<?php

class BuyerService
{
	private const
		K = 20,
		GEN_INTERVAL = 600; // seconds

	public static function generateBuyers(int $time, int $worktime): array
	{
		$newBuyers = [];
		$i = 0;
		$count = self::generateBuyersCount($time, $worktime);
		while ($i < $count) {
			$i++;
			$newBuyers[] = new Buyer();
		}

		return $newBuyers;
	}

	private static function generateBuyersCount(int $time, int $worktime): int
	{
		if ($time % self::GEN_INTERVAL === 0) {
			$tinterval = round($time / self::GEN_INTERVAL);
			$ranges = $worktime / self::GEN_INTERVAL;
			$count = round(sin($tinterval * (M_PI / $ranges)) * self::K);
			return $count;
		}

		return 0;
	}

}
