<?php

// Testdrive for classes. 
// Characters.php "has-a" Property.php
// Abilities.php, Aliases.php, Books.php, etc. "is-a" Property.

require_once 'autoload.php';

$c = new Character_urls();
$ab = new Abilities();
$al = new Aliases();
$b = new Books();
$e = new Ethnicity();
$g = new Gender();
$nam = new Name();
$nat = new Nationality();
$o = new Occupation();
$s = new Status();
$t = new Titles();

$char = new Characters();
$prop = new Property();

$char->addProperty($c);
$char->addProperty($ab);
$char->addProperty($al);
$char->addProperty($b);
$char->addProperty($e);
$char->addProperty($g);
$char->addProperty($nam);
$char->addProperty($nat);
$char->addProperty($o);
$char->addProperty($s);
$char->addProperty($t);

$char->scrapeProperties();
//$char->saveToDatabaseIds();

?>