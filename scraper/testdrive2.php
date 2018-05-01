<?php

/*/////////////////////////////////////////////////////////////////////////////////////////////////////
//
//		Regex list:
//
//	'/Biographical information<\/th>.+?>Abilities<\/th>.+?>(.+?)<\/td>/';
//	'/Social Information<\/th>.+?>Aliases<\/th>.+?>(.+?)<\/td>/';
//	'/Social Information<\/th>.+?>Appears in<\/th>.+?>(.+?)<\/td>/';
//	'/style="text-align:center; font-size:125%; font-weight:bold;">(.+?)<\/th>/';  (character names)
//	'/Biographical information<\/th>.+?>Ethnicity<\/th>.+?>(.+?)<\/td>/';
//	'/Biographical information<\/th>.+?>Nationality<\/th>.+?>(.+?)<\/td>/';
//	'/Biographical information<\/th>.+?>Gender<\/th>.+?>(.+?)<\/td>/';
//	'/Social Information<\/th>.+?>Occupation<\/th>.+?>(.+?)<\/td>/';
//	'/Biographical information<\/th>.+?>Status<\/th>.+?>(.+?)<\/td>/';
//	'/Social Information<\/th>.+?>Title\(s\)<\/th>.+?>(.+?)<\/td>/';
//
//////////////////////////////////////////////////////////////////////////////////////////////////////*/

// Procedural based script to build relationship tables in MySQL.
// Must replace regex in scrape() function. 
// Must replace table and field in query with appropriate values depening on regex being used.
// Functions are in alphabetical order.

$link = mysqli_connect("localhost", "user", "password", "database");

	function clean(array $properties_array) {
		foreach ($properties_array as $properties) {
			$properties = explode(',', $properties);
			foreach ($properties as $property) {
				$split_array[] = $property;
			}
		}
		$split_array = array_map('strip_tags', $split_array);
		$clean_array = array_map('trim', $split_array);
		return ($clean_array);
	}

	function cleanHtml($html) {
		$string = str_replace("\n", ' ', $html);
		$string = preg_replace('/\s{2,}/', ' ', $string);
		$string = preg_replace('/\[[0-9]\]/', ' ', $string);	// replace wiki citation text
		return $string;
	}

		function combineHtml() {
		$html1 = file_get_contents("http://stormlightarchive.wikia.com/wiki/Category:Characters");
		$html2 = file_get_contents("http://stormlightarchive.wikia.com/wiki/Category:Characters?page=2");
		$html3 = file_get_contents("http://stormlightarchive.wikia.com/wiki/Category:Characters?page=3");
		$html = $html1 . $html2 . $html3;
		return $html;
	}

	function scrapeUrls($string) {
		$url_regex = '/<li><a href="\/wiki\/(.+?)" title=".+?">.+?<\/a><\/li>/';
		if (preg_match_all($url_regex, $string, $matches)) $characters = $matches[1];
		foreach ($characters as $character) {
			$character_url = "http://stormlightarchive.wikia.com/wiki/$character";
			$character_urls[] = $character_url;
		}
		return $character_urls;
	}

	function scrape($character_url) {
		$regex = '/Social Information<\/th>.+?>Title\(s\)<\/th>.+?>(.+?)<\/td>/';
			$html = file_get_contents($character_url);
			$string = cleanHtml($html);	
			if (preg_match($regex, $string, $matches)){
			} else {
				$matches[1] = "NULL";
			}
			$properties_array[] = $matches[1];
		return ($properties_array);
	}

$html = combineHtml();
$string = cleanHtml($html);
$character_urls = scrapeUrls($string);

$i = 0;

while ($character_urls[$i]) {

	$properties_array = scrape($character_urls[$i]);
	$properties_array = clean($properties_array);

	if (strlen($character_urls[$i]) > 0) {
		$db_value = "'" . mysqli_real_escape_string($link, $character_urls[$i]) . "'";
	} else {
		$db_value = "NULL";
	}
	$query ="SELECT character_id FROM characters WHERE character_url = $db_value";
	$results = mysqli_query($link, $query);
	$rows = mysqli_fetch_assoc($results);
	foreach ($rows as $key => $value) {
		$char_id = $value;
	}

	// "$query = "INSERT INTO [table of choice] (character_id, [field of table]) VALUES ({$char_id}, {$db_value})";
	foreach ($properties_array as $property) {
		$db_value = "'" . mysqli_real_escape_string($link, $property) . "'";
		$query = "INSERT INTO characters_title (character_id, title) VALUES ({$char_id}, {$db_value})";
		//echo $query . "\n";
		$results =  mysqli_query($link, $query);
		//print_r($rows);
		$properties_array = array();
	}
	$i++;
}

?>