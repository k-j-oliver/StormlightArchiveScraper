<?php 

class Name extends Property {

	protected $table = "name";
	protected $field = "name";
	protected $id = "name_id";
	protected $regex = '/style="text-align:center; font-size:125%; font-weight:bold;">(.+?)<\/th>/';
}

?>