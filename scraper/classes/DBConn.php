<?php

class DBConn {

// moving the actual database connection, not a copy of the connection.
// this is called a SINGLETON class; it makes sure there's one of them. 
// App preferences and settings are often singletons. 

	protected static $connection;

	// make it impossible for clients to build an object. 
	private function __construct() {}

	public static function getConnection() {
		if (empty(self::$connection)) { // "self::$connection" refers to the class without an object being made first. [$this->connection]
			self::$connection = new MySQLi('localhost', 'user', 'password', 'database');
			self::$connection->set_charset('utf8');
		}
		return self::$connection; 		// returns the same connection if found. 
	}
}

?>