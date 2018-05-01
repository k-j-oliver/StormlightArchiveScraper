<?php

class Ethnicity extends Property {

	protected $table = "ethnicity";
	protected $field = "ethnicity";
	protected $id = "ethnicity_id";
	protected $regex = '/Biographical information<\/th>.+?>Ethnicity<\/th>.+?>(.+?)<\/td>/';

}
?>