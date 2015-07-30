<?php

include_once 'functions.php';
try
{
	$campaigns = parseCampaigns('campaigns.csv');
}
catch (Exception $e)
{
	error_log($e->getMessage());
	$campaigns = [];
}

if ( ! empty($campaigns))
{
	try
	{
		$banners = parseBanners('banners.csv', $campaigns);
	}
	catch (Exception $e)
	{
		error_log($e->getMessage());
		$banners = [];
	}
}

if ( ! empty($banners) && ! empty($_GET['group']))
{
	$data = groupBy($_GET['group'], $banners);
	echo json_encode($data);
}
else
{
	echo json_encode($banners);
}

