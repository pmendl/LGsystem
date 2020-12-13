<?php
session_start();

require("../Tools/database.php");


/*	echo "<div class=\"system-report\">ACTION=${_POST['action']}<div>"; */

if($_POST["action"] == "LOGIN") {
	Database::DbOpen();
/*	echo "</br>";
	if (is_object(Database::$conn)) {
		echo "1: IS OBJECT</br>";			
//				echo Database::$conn->getAttribute(PDO::ATTR_CONNECTION_STATUS) . "???";
//				echo Database::DB_USER;
	} else {
				echo "1: NOT OBJECT</br> ";
	}
	echo "NOW ";
 */
}
	
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
		<div class="header-footer">
			LUCKY GO System - Přihlášení uživatele
		</div>
		
		<div class="main-box">
		
		<?php
		
		if (isset(Database::$error_message)) {
			$error_message = $servername . ":" . $port . "&emsp;" . Database::$error_message;
		} else {
			echo '<div class="system-report">';
			if (is_object(Database::$conn)) {
				
//				echo Database::$conn->getAttribute(PDO::ATTR_CONNECTION_STATUS) . "???";
//				echo Database::DB_USER;
			} else {
				echo "NOT OBJECT ";
			}
			print_r($_POST);
			echo "</br>";
			if(Database::$conn == FALSE) {
				echo "DB FAILED! ";
			} else {
				$driver_name =Database::$conn->getAttribute(PDO::ATTR_DRIVER_NAME);
		    	$conn_stat =Database::$conn->getAttribute(PDO::ATTR_CONNECTION_STATUS);
				echo "Connected successfully: $driver_name at " . $conn_stat . "</br>";
				
				
				$select = Database::$conn->prepare("SELECT id, password_hash FROM user WHERE username = ?");
			} 
//			echo "<div>TEST3</div>";
			if (!$select->execute(array($_POST["username"]))) {
				$error_message = "Selhal dotaz SELECT na uživatele.";
				echo  $error_message; 
			} else {
				$result=$select->fetch(PDO::FETCH_ASSOC);
//				echo $result;
				if (!$result) {
					echo "Zadaný uživatel nemá oprávnění užívat tento systém. Prosím, zkontrolujte své přihlašovací údaje.";
				} else {
//					echo '<div class="system-report">';
					print_r($result);
//					echo  "</br>---</br>"."TEST </div>";
					if($result[password_hash]) {
//						echo "TODO: verify password";
					} else {
						$password_change="new";
//						echo <<<EOT
//						TODO: set new password
//EOT; 
					}
				}
				
			}
			echo '</div>';
		}
		
		if (isset($error_message)) {
			echo "<div><p> Došlo k interní chybě systému. Prosím informujte správce systému  
			na telefonu 602 645 347 a sdělte mu následující chybu:</p>"; 
			echo '<p style="background:yellow">' . $error_message . "<\p></div>";
		}
		
		if ($password_change) {
			echo <<<EOT
			<form action="/Login/password_change.php" method="post">  
				<div class="login-rows">
					<table>
EOT;
			if ($password_change == "new") {
				echo <<<EOT
							<tr><td>Pro první přihlášení si, prosím, zvolte heslo, které budete nadále používat.<td/><tr/>
							<input type="hidden" name="old_password" value=""/>
EOT;
			} else {				
				echo <<<EOT
							<tr><td>Zvolte nové heslo:<td/><tr/>
							<tr><td><label for="old_password">Původní heslo:</label></td></tr>
							<tr><td><input type="password" name="old_password" /></td></tr>
EOT;
			}
				echo <<<EOT
							<tr><td><label for="password1">Nové heslo:</label></td></tr>
							<tr><td><input type="password" id="password1" name="password1" oninput="myUpdate(event)" /></td><td><span id="passNotNull" class="unmet-login-condition">Nesmí být prázdné</td></span></tr>
							<tr><td><label for="password2">Znovu pro potvrzení:</label></td></tr>
							<tr><td><input type="password" id="password2" name="password2" oninput="myUpdate(event)" /></td><td><span id="passEqual" class="unmet-login-condition">Musí se shodovat</span></td></tr>
							<tr><td><button id="password_send" type="submit" disabled />Odeslat</button><button type="button" onclick="reloadIndex()">Zrušit</button></td><td></td></tr>
					</table>
				</div>
				
				
EOT;
		} else {
			echo '<button type="button" onclick="reloadIndex()">OK</button>';
		}
		
			
		?>
		</div>		
		<script language="javascript" type="text/javascript" src="/Tools/footer.js"></script>
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