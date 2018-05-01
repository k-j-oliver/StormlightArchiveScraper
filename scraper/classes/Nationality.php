<?php

class Nationality extends Property {

	protected $table = "nationality";
	protected $field = "nationality";
	protected $id = "nationality_id";
	protected $regex = '/Biographical information<\/th>.+?>Nationality<\/th>.+?>(.+?)<\/td>/';
}

?>