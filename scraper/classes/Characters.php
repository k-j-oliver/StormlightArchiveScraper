<?php

require_once 'autoload.php';

class Characters implements Iterator, Countable {

	protected $index = 0;
	protected $properties = array();

	public function addProperty(Property $new_property) {
		$this->properties[] = $new_property;
	}

	public function scrapeProperties() {
		foreach ($this->properties as $property) {
			$property->combineHtml();
			$property->scrapeUrls();
			$property->scrape();
			//$property->saveToDatabase();			// used to fill database with single entity tables 
		}	
	}

/////////////////////////////////////////////////////////

	public function current() {
		return $this->properties[$this->index];
	}

	public function key() {
		return $this->index;	
	}

	public function next() {
		$this->index++;
	}

	public function rewind() {
		$this->index = 0;
	}

	public function valid() {
		return isset($this->properties[$this->index]);
	}

	public function count() {
		return count($this->properties);
	}

}
?>