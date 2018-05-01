<?php

// throw-away code for collecting data for JSON encode. 
// do one block of code at a time for each "$value = 'blah'"

require_once 'classes/DBConn.php';

// testing the connection
$db = DBConn::getConnection();

$value = $_GET['viz'];

$query = "SELECT * FROM $value";
$result = $db->query($query);

$viz = array();

foreach ($result as $row) {
	$viz[] = $row;
}

// echo json_encode($viz);

$value = 'book';

if ($value == 'book') {
	$query = "SELECT book FROM book";
	$result = $db->query($query);
	while ($rows = $result->fetch_assoc()) {
		$books[] = $rows['book'];
	}
	foreach ($books as $book) {
		// do not want to show NULL values in graph.
		if ($book == "NULL") continue;
		$db_value = "'" . $db->real_escape_string($book) . "'";
		$query = "SELECT COUNT(character_id) AS NumberOfCharacters, book FROM characters_book WHERE book = $db_value";
		$result = $db->query($query);
		$row = $result->fetch_assoc();
		$counts[] = $row;
	}
	$handle = fopen('book.json', 'w');
	fwrite($handle, json_encode($counts));
	fclose($handle);
	//echo json_encode($counts);
}

$value = 'status';

if ($value == 'status') {
	$query = "SELECT status FROM status";
	$result = $db->query($query);
	while ($rows = $result->fetch_assoc()) {
		$books[] = $rows['status'];
	}
	foreach ($books as $book) {
		$db_value = "'" . $db->real_escape_string($book) . "'";
		$query = "SELECT COUNT(character_id) AS NumberOfCharacters, status FROM characters_status WHERE status = $db_value";
		$result = $db->query($query);
		$row = $result->fetch_assoc();
		$counts[] = $row;
	}
	//print_r($counts);
	 $handle = fopen('CountStatusResults.json', 'w');
	fwrite($handle, json_encode($counts));
	fclose($handle);
}

$value = 'gender';

if ($value == 'gender') {
	$query = "SELECT gender FROM gender";
	$result = $db->query($query);
	while ($rows = $result->fetch_assoc()) {
		$books[] = $rows['gender'];
	}
	foreach ($books as $book) {
		$db_value = "'" . $db->real_escape_string($book) . "'";
		$query = "SELECT COUNT(character_id) AS NumberOfCharacters, gender FROM characters_gender WHERE gender = $db_value";
		$result = $db->query($query);
		$row = $result->fetch_assoc();
		$counts[] = $row;
	}
	//print_r($counts);
	 $handle = fopen('CountGenderResults.json', 'w');
	fwrite($handle, json_encode($counts));
	fclose($handle);
}


?>