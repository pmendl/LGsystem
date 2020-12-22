<?php
// --- PREAMBLE CODE ---
session_start();
ob_start();
try {
// --- PAGE CODE START ---
?>

<?php
if($_POST["action"] == "CLEAR") {
	unset($_SESSION["user_id"]);
}
?>

<!DOCTYPE html>
<html>
   	<head>
    	<meta charset="UTF-8">
      
      	<title>Lucky Goo internal system</title>

  		<link rel="stylesheet" type="text/css" href="/CSS/page_layout.css">
  		<link rel="stylesheet" type="text/css" href="/CSS/login.css">
		<style>
		
			button {
				margin: 15px auto;
			}

  		</style>
      
	</head>
	<body> 
		<div class="header">
			LUCKY GO System - Přihlášení uživatele
		</div>
		
		<div class="main-box">
			<div class="system-report">
		
		<?php

		print_r($_POST);
		if($_POST["action"] == "LOGIN") {
			require("../Tools/database.php");
//			echo '<div class="system-report">';

			$db=new Database("database.ini",true);
			if (!is_object($db->conn)) {
				throw new Exception("Database connection is not an object", 1001);
			}
			if(!$db->conn) {
				throw new Exception("Database connection open failed", 1002);
			}

			$driver_name =$db->conn->getAttribute(PDO::ATTR_DRIVER_NAME);
	    	$conn_stat =$db->conn->getAttribute(PDO::ATTR_CONNECTION_STATUS);
			echo "Connected successfully: $driver_name at " . $conn_stat . "</br>";
			
			$select = $db->conn->prepare('SELECT id, password_hash FROM user WHERE username = ?');
			if (!$select->execute(array($_POST['username']))) {
				throw new Exception("Selhal dotaz SELECT na uživatele " . $_POST['username'], 1003);
			}

			$result=$select->fetch(PDO::FETCH_ASSOC);
			if (!$result) {
				echo "</br></div><div class=\"main-warning\">Uživatel ". $_POST['username'] . " nemá oprávnění užívat tento systém. Prosím, zkontrolujte své přihlašovací údaje.</div>";
			} else {
				echo '<div class="system-report">';
				print_r($result);
				echo  "</br></br>";
				$password_change="new";
				if(strpos($result['password_hash'], '$$')=== 0) {
					if(strlen($result['password_hash'])==2)
					{
						// TODO: $hash= default password 
					} else {
						$hash=substr($result['password_hash'],2);
					}
//								echo "TODO: verify password and eventually rehash";
//EOT; 
				}
				echo "</div>";
			}
			echo "</div>";
										
////
////
////			
		}
		
		
		if ($password_change) {
			echo <<<EOT
				<form action="/Login/password_change.php" method="post">  
					<div class="login-rows">
						<table>

EOT;
//				if ($password_change == "new") {
				echo <<<EOT
								<tr><td colspan="2">Pro první přihlášení si, prosím, zvolte heslo, které budete nadále používat.<td/><tr/>
								<tr><td><input type="hidden" name="old_password" value=""/><td/><tr/>

EOT;
//				} else {				
				echo <<<EOT
								<tr><td>Zvolte nové heslo:<td/><tr/>
								<tr><td><label for="old_password">Původní heslo:</label></td></tr>
								<tr><td><input type="password" name="old_password" /></td></tr>

EOT;
//				}
				echo <<<EOT
								<tr><td><label for="password1">Nové heslo:</label></td></tr>
								<tr><td><input type="password" id="password1" name="password1" oninput="myUpdate(event)" /></td><td><span id="passNotNull" class="unmet-login-condition">Nesmí být prázdné</span></td></tr>
								<tr><td><label for="password2">Znovu pro potvrzení:</label></td></tr>
								<tr><td><input type="password" id="password2" name="password2" oninput="myUpdate(event)" /></td><td><span id="passEqual" class="unmet-login-condition">Musí se shodovat</span></td></tr>
								<tr><td><button id="password_send" type="submit" disabled />Odeslat</button><button type="button" onclick="reloadIndex()">Zrušit</button></td><td></td></tr>
						</table>
					</div>
					
					
EOT;
		} else {
			echo '<button type="button" onclick="reloadIndex()">OK</button>';
		}
		echo "</div></div>";

		include "../Tools/footer.html";
		?>
	
		<script>
			function reloadIndex() { window.location.assign("/"); }
			function myUpdate(event) {
				p1=document.getElementById("password1");
				p2=document.getElementById("password2");
				if (p1.value.length>0) {
					document.getElementById("passNotNull").style.visibility="hidden";
					if (p1.value==p2.value) {
						document.getElementById("passEqual").style.visibility="hidden";
						document.getElementById("password_send").disabled=false;
					} else {
						document.getElementById("passEqual").style.visibility="";
						document.getElementById("password_send").disabled=true;
					} 
				} else {
					document.getElementById("passNotNull").style.visibility="";
					document.getElementById("passEqual").style.visibility="";
					document.getElementById("password_send").disabled=true;
				}
			}
		</script>
	</body>
</html>

<?php
// --- PAGE CODE END ---
	ob_end_flush();
} catch (Exception $e) {
	ob_end_clean();
	include $_SERVER[DOCUMENT_ROOT] . "/Tools/exception_report.php";
}
?>	
