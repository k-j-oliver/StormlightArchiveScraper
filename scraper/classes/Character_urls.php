<?php

class Character_urls extends Property {
	
	protected $table = "characters";
	protected $field = "character_url";
	protected $id = "character_id";

	public function scrape() {
		return;
	}

	public function saveToDatabase() {
		foreach ($this->charcter_urls as $character_url) {
			$db_values = $this->cleanForDB($character_url);
			$query = "INSERT INTO {$this->table} ({$this->id}, {$this->field}) VALUES (NULL, $db_values)";
			$result = $this->db->query($query);
		}
	}

}

?>