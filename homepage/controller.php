<?php
/**
 * Controller for the home page.
 * @link https://wuwana.com/
 * @license https://mozilla.org/MPL/2.0 This Source Code Form is subject to the terms of the Mozilla Public License v2.0
 */

$categories = WebApp\Data::getCategory()->selectAll();
$locations = WebApp\Data::getLocation()->selectUsefulItemsOnly('es');

$limit = filter_has_var(INPUT_GET, 'show') ? 0 : 8;

$selectedCategories = [];
$selectedRegions = [];

/*
if (filter_has_var(INPUT_GET, 'cat'))
{
	foreach ($categories as $key => $value)
	{
		if (filter_has_var(INPUT_GET, 'cat' . $key))
		{ $selectedCategories[] = $key; }
	}

	$limit = 0;
}
*/

foreach ($locations as $id => $unused)
{
	if (filter_has_var(INPUT_GET, 'region' . $id))
	{
		$selectedRegions[] = $id;
		$limit = 0;
	}
}

if(filter_has_var(INPUT_GET, 'logout'))
{ $user->logout(); }

//$companies = WebApp\Data::getCompany()->selectCategoriesRegions($selectedCategories, $selectedRegions, $limit);
$companies = WebApp\Data::getCompany()->selectCategoriesRegions($language, [], $selectedRegions, $limit);
$counter = count($companies);