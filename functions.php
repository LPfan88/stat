<?php
/**
 * @param string $file CSV-file
 *
 * @return array [campaign_id => [id => 555, name => Campaign name, ...]
 * @throws Exception
 */
function parseCampaigns($file)
{
	if ( ! file_exists($file))
	{
		throw new Exception('File not found');
	}

	$campaignsFile = file($file);
	$head = str_getcsv($campaignsFile[0], ';');
	unset($campaignsFile[0]);
	$campaigns = [];
	foreach ($campaignsFile as $row)
	{
		$row = str_getcsv(trim($row), ';');
		$row = array_combine($head, $row);
		$row['banners'] = [];
		$row['campaign_id'] = $row['id'];
		unset($row['id']);

		$campaigns[$row['campaign_id']] = $row;
	}

	return $campaigns;
}

/**
 * @param $file
 * @param $campaigns
 *
 * @return array
 * @throws Exception
 */
function parseBanners($file, $campaigns)
{
	if ( ! file_exists($file))
	{
		throw new Exception('File not found');
	}


	$bannersFile = file($file);
	$head = str_getcsv($bannersFile[0], ';');
	unset($bannersFile[0]);
	$banners = [];
	foreach ($bannersFile as $row)
	{
		$row = str_getcsv(trim($row), ';');
		$row = array_combine($head, $row);

		// PHP doesn't read numbers like '5,43' as float
		$row['costs'] = (float) str_replace(',', '.', $row['costs']);
		if ( ! isset($campaigns[$row['campaign_id']]))
		{
			continue;
		}

		$banners[] = $campaigns[$row['campaign_id']] + $row;
	}

	return $banners;
}

/**
 * @param $field
 * @param $data
 *
 * @return array [['name' => 'Some name', 'clicks' => 555, 'shows' => 323, 'costs' => 43422.44, 'rows' => [...], 'cpc' => 4.11], ...]
 * @throws Exception
 */
function groupBy($field, $data)
{
	if ( ! in_array($field, ['campaign_id', 'name', 'sex', 'age_from', 'age_to', 'budget_limit', 'payment_type', 'title']))
	{
		throw new Exception('Field is not valid');
	}

	$return = [];
	foreach ($data as $row)
	{
		if ( ! isset($return[$row[$field]]))
		{
			$return[$row[$field]] = [
				$field => $row[$field],
			    'clicks' => $row['clicks'],
			    'shows' => $row['shows'],
			    'costs' => $row['costs'],
			    'rows' => []
			];
		}
		else
		{
			$return[$row[$field]]['clicks'] += $row['clicks'];
			$return[$row[$field]]['shows'] += $row['shows'];
			$return[$row[$field]]['costs'] += $row['costs'];
		}

		$return[$row[$field]]['rows'][] = $row;
	}

	// After the groups we can calculate CPC for each row
	$return = array_map(function($item)
	{
		if ($item['clicks'] == 0)
		{
			$item['cpc'] = 0;
		}
		else
		{
			$item['cpc'] = round($item['costs'] / $item['clicks'], 2);
		}

		return $item;
	}, $return);

	return array_values($return);
}