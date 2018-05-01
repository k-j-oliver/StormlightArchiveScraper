<?php

class Aliases extends Property {

	protected $table = "alias";
	protected $field = "alias";
	protected $id = "alias_id";
	protected $regex = '/Social Information<\/th>.+?>Aliases<\/th>.+?>(.+?)<\/td>/';

}

?>