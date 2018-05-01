<?php

class Occupation extends Property {

	protected $table = "occupation";
	protected $field = "occupation";
	protected $id = "occupation_id";
	protected $regex = '/Social Information<\/th>.+?>Occupation<\/th>.+?>(.+?)<\/td>/';
}

?>