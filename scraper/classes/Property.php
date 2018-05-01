<?php 

require_once 'autoload.php';

class Property {

	protected $char_ids = array();
	protected $character_urls = array();		// filled by Character_urls object
	protected $db;								// database connection
	protected $db_value; 						// cleaned values for saveToDatabase()
	protected $html;							// holds combined html from main wiki pages.
	protected $ids = array();					// holds queried ids for filling relationship tables.
	protected $parameters = array();
	protected $properties = array();
	protected $arrays = array();
	protected $regex;
	protected $split_arrays = array();
	protected $table;
	protected $clean_arrays = array();

	public function __construct() {
		$this->db = DBConn::getConnection();
	}

	// get the html from each character URL.
	// pass html string to cleanString method.
	public function characterHtml($character_url) {
		$this->html = file_get_contents($character_url);
		$this->cleanString($this->html);	
	}

	public function cleanArray(array $array) {
		$this->clean_arrays = array_map('strip_tags', $array);
		$this->clean_arrays = array_map('trim', $this->clean_arrays);
		//$this->clean_arrays = array_unique($this->clean_arrays);			// used after scraping to fill single entity table with unique values.
		//print_r($this->clean_arrays);
	}

	public function cleanForDB($string) {
		if (strlen($string) > 0) {
			return "'" . $this->db->real_escape_string($string) . "'";
		} else {
			return 'NULL';
		}
	}

	public function cleanString($new_html) {
		$this->string = str_replace("\n", ' ', $new_html);
		$this->string = preg_replace('/\s{2,}/', ' ', $this->string);
		$this->string = preg_replace('/\[[0-9]\]/', ' ', $this->string);	// replace wiki citation text
	}

	// collect html into work-able form (combine three pages).
	// pass html string to cleanString method.
	public function combineHtml() {
		$html = file_get_contents("http://stormlightarchive.wikia.com/wiki/Category:Characters");
		$html2 = file_get_contents("http://stormlightarchive.wikia.com/wiki/Category:Characters?page=2");
		$html3 = file_get_contents("http://stormlightarchive.wikia.com/wiki/Category:Characters?page=3");
		$this->html = $html . $html2 . $html3;

		$this->cleanString($this->html);
	}

	// used on initial scrape to fill single-entity database tables.
	// called by Characters composition. 
	public function saveToDatabase() {
		foreach ($this->clean_arrays as $values) {
			$db_value = $this->cleanForDB($values);
			$query = "INSERT INTO {$this->table} ({$this->id}, {$this->field}) VALUES (NULL, $db_value)";
			$results = $this->db->query($query);
		}
	}

	public function scrapeUrls() {
		$url_regex = '/<li><a href="\/wiki\/(.+?)" title=".+?">.+?<\/a><\/li>/';
		if (preg_match_all($url_regex, $this->string, $matches)) $characters = $matches[1];
		foreach ($characters as $character) {
			$character_url = "http://stormlightarchive.wikia.com/wiki/$character";
			$this->character_urls[] = $character_url;
		}
	}

	public function scrape() {
		foreach ($this->character_urls as $character_url) {
		//$character_url = "http://stormlightarchive.wikia.com/wiki/Kaladin";	// used for testing one character
			$this->characterHtml($character_url);
			if (preg_match($this->regex, $this->string, $matches)){
			} else {
				$matches[1] = "NULL";
			}
			$this->arrays[] = $matches[1];
			$this->split($this->arrays);
			$this->writeCSV($character_url);
		}
		$this->split($this->arrays);
		
	}

	// split comma separated values from initial scrape. 
	// send to clean method for final storage in $clean_arrays.
	public function split(array $arrays) {
		foreach ($arrays as $array) {
			$arrays = explode(',', $array);
			foreach ($arrays as $array) {
				$this->split_arrays[] = $array;
			}
		}
		//print_r($this->split_arrays);
		$this->cleanArray($this->split_arrays);
	}
}

?>