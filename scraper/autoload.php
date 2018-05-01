<?php

function __autoload($class) {
	$filename = "classes/" . $class . ".php"; 
	require_once $filename;
}

?>