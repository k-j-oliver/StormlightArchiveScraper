<?php

class Titles extends Property {

	protected $table = "title";
	protected $field = "title";
	protected $id = "title_id";
	protected $regex = '/Social Information<\/th>.+?>Title\(s\)<\/th>.+?>(.+?)<\/td>/';

}

?>