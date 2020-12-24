<?php
/**
 * Controller for the home page.
 * @link https://wuwana.com/
 */

spl_autoload_register(function($className) {
	require 'Models/' . str_replace('\\', '/', $className) . '.php';
});

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

$user = new WebApp\UserSession(WebApp\Data::getUser());

if(filter_has_var(INPUT_GET, 'logout'))
{ $user->logout(); }

$language = WebApp\WebApp::getLanguageCode();

//$companies = WebApp\Data::getCompany()->selectCategoriesRegions($selectedCategories, $selectedRegions, $limit);
$companies = WebApp\Data::getCompany()->selectCategoriesRegions($language, [], $selectedRegions, $limit);

require 'Templates/text ' . $language . '.php';
require 'homepage/text ' . $language . '.php';
require 'homepage/view.php';

if (memory_get_peak_usage() > WebApp\WebApp::MEMORY_LIMIT)
{ trigger_error(memory_get_peak_usage() . ' Bytes of memory used', E_USER_NOTICE); }