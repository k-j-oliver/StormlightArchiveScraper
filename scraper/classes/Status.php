<?php

class Status extends Property {

	protected $table = "status";
	protected $field = "status";
	protected $id = "status_id";
	protected $regex = '/Biographical information<\/th>.+?>Status<\/th>.+?>(.+?)<\/td>/';

}

?>