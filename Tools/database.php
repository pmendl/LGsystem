<?php	
class Database
{
	public $conn;

	function __construct(...$args) {

		// Database constructor passes it's parameters to the parse_ini_file()
		// which in turn parses parameters for the given database 
		$ini_array = parse_ini_file(...$args);
		// It is recognized whether sections are used by parse_ini_file(),
		// in which case [Database] section values are extracted 
		if(count($args) >= 2 && $args[1]) {
			$db_params = $ini_array['Database'];
		} else {
			$db_params = $ini_array;
		}
		var_dump($db_params);
		echo("</br>");
		
	
		// Create connection from parsed data
	    $this->conn = new PDO("mysql:host=".$db_params['DB_SERVER'].
	    	";port=".$db_params['DB_PORT'].";dbname=".$db_params['DB_NAME'], 
	    	$db_params['DB_USER'], $db_params['DB_PASSWORD']);
	
		// CRITICAL: make sure PHP does not preprocess prepared queries to be safe about SQL insertion
		$this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	    // set the PDO error mode to exception
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
/*		CODE FOR DEBUG PURPOSES		
		$driver_name = $this->conn->getAttribute(PDO::ATTR_DRIVER_NAME);
	    $conn_stat = $this->conn->getAttribute(PDO::ATTR_CONNECTION_STATUS);
		echo "Database: Connected successfully: $driver_name at $conn_stat</br>";
*/
	}
}

?>	