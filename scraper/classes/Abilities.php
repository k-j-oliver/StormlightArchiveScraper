<?php

class Abilities extends Property {

	protected $table = "ability";
	protected $field = "ability";
	protected $id = "ability_id";
	protected $regex = '/Biographical information<\/th>.+?>Abilities<\/th>.+?>(.+?)<\/td>/';

}

?>