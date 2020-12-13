<!DOCTYPE html>
<html>
   <head>
      <meta charset="UTF-8">
      
      <title>Lucky Goo internal system</title>

      <style>
      .super-outer-box {
      	height: 95vh;
      	max-height: 100vh;
        display: flex;
		flex-direction:column;
      }
      
      .header-footer {
        display: flex;
		justify-content: space-around;
		color: White;
        background-color: DodgerBlue;
        font-size: 0.8em;
        padding: 2px;
        margin: 5px 0px;
      }

      .header-footer > a {
		color:white;
      }
      
      .main-box {
      	display: flex;
      	border: 1px solid black;
      	flex-growth:1; 
      	max-height: 70vh;
      }
      
      .structure-box {
      	border: inherit;
      	padding: 10px;
      	margin: 2px 1px 2px 2px;
      }

      .table-box {
      	display:flex;
     	flex-direction: column;
      	border: inherit;
      	margin: 2px 2px 2px 1px;
      	width: 100%;
  		overflow:auto;
  		/* For Firefox */
  		min-height:0;
      }
      
      </style>

	  <link rel="stylesheet" type="text/css" href="/Structure/query_structure.css">
	  <link rel="stylesheet" type="text/css" href="/Provisions/provisionsTable.css">
	
	</head>
<body>

<div class="super-outer-box">

<?php
echo "CURRENT DIRECTORY: " . getcwd() . "&emsp;&emsp;&emsp;CURRENT URL: " . $_SERVER['REQUEST_URI'] . "&emsp;&emsp;&emsp;DIR: " . __DIR__ . "<br/>";     

echo '<div class="header-footer">';
date_default_timezone_set('Europe/Prague');
$servername ="";
$port = "";
$username = "";
$password = "";
global $conn;

try {
    $conn = new PDO("mysql:host=$servername;port=$port;dbname=lucky_goo", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $driver_name = $conn->getAttribute(PDO::ATTR_DRIVER_NAME);
    $conn_stat = $conn->getAttribute(PDO::ATTR_CONNECTION_STATUS);
	echo "Connected successfully: $driver_name at $conn_stat";

}
catch(PDOException $e) {
    echo "Processing failed: " . $e->getMessage();
}
?> 
</div>
<div class="main-box">
	<div class="structure-box">
<?php
//	echo $_SERVER['SCRIPT_FILENAME'];
//	echo __DIR__;
	require getcwd() . "/query_structure.php";
	placeBossContainer(0, $conn);
?>
	</div>
	<div class="table-box">
<?php
	require getcwd() ."/../Provisions/provisionsTable.php"; 
?>
	
	</div>
</div>

<div  class="header-footer">
   <a title="PHP manual" href="https://www.php.net/manual/en/">PHP manual</a>
   <a title="Details about Laragon" href="laragon.php">Details about Laragon</a>
</div>

</div>

</body>
</html> 