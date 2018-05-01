<?php

class Gender extends Property {

	protected $table = "gender";
	protected $field = "gender";
	protected $id = "gender_id";
	protected $regex = '/Biographical information<\/th>.+?>Gender<\/th>.+?>(.+?)<\/td>/';

}

?>