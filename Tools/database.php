<?php	
class Database
{
	static public $conn;
	static public $error_message;

	static public function DbOpen() {

		// Parse with sections
		$ini_array = parse_ini_file("database.ini",true);
	
		// Create connection from parsed data			
	    self::$conn = new PDO("mysql:host=".$ini_array["Database"]["DB_SERVER"].
	    	";port=".$ini_array["Database"]["DB_PORT"].";dbname=".$ini_array["Database"]["DB_NAME"], 
	    	$ini_array["Database"]["DB_USER"], $ini_array["Database"]["DB_PASSWORD"]);
	
		// CRITICAL: make sure PHP does not preprocess prepared queries to be safe about SQL insertion
		self::$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	    // set the PDO error mode to exception
		self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
/*		CODE FOR DEBUG PURPOSES		
		$driver_name = self::$conn->getAttribute(PDO::ATTR_DRIVER_NAME);
	    $conn_stat = self::$conn->getAttribute(PDO::ATTR_CONNECTION_STATUS);
		echo "Database: Connected successfully: $driver_name at $conn_stat</br>";
*/
		
		return $conn;
	}
}

?>	