<?php

class Books extends Property {

	protected $table = "book";
	protected $field = "book";
	protected $id = "book_id";
	protected $regex = '/Social Information<\/th>.+?>Appears in<\/th>.+?>(.+?)<\/td>/';

}

?>