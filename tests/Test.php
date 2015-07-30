<?php

class Test extends PHPUnit_Framework_TestCase {
	public function testGroup()
	{
		include_once dirname(__DIR__) . '/functions.php';
		$campaigns = parseCampaigns(__DIR__ . '/test_campaigns.csv');
		$banners = parseBanners(__DIR__ . '/test_banners.csv', $campaigns);
		$group = 'campaign_id';

		$expected = [
			['campaign_id' => 5, 'shows' => 411, 'clicks' => 64, 'costs' => 298, 'cpc' => 4.66],
			['campaign_id' => 6, 'shows' => 3616, 'clicks' => 13, 'costs' => 132, 'cpc' => 10.15],
		];

		$this->assertEquals($expected, groupBy($group, $banners));
	}
}
