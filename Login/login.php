<?php
// --- PREAMBLE CODE ---
session_start();
ob_start();
try {
	include $_SERVER[DOCUMENT_ROOT] . "/Tools/header.php";
	$h = new Header;
	$h->setSubtitle("Přihlášení uživatele");
	unset($h);
// --- PAGE CODE START ---
//	print_r($_POST);
?>
	<div class="main-box">
		<div class="system-report">

<?php

	print_r($_POST);
	switch ($_POST['action']) {
		case 'CLEAR':
			unset($_SESSION["user_id"]);
			echo "CLEAR done !!!<br/>";
		case 'LOGIN':
			echo "Point 1<br/>";
			print_r($_POST);
			echo __DIR__;
			require(__DIR__ . "/../Tools/database.php");
			echo "Point 2<br/>";
			$db=new Database("database.ini",true);
			if (!is_object($db->conn)) {
				throw new Exception("Database connection is not an object", 1001);
			}
			if(!$db->conn) {
				throw new Exception("Database connection open failed", 1002);
			}

			$driver_name =$db->conn->getAttribute(PDO::ATTR_DRIVER_NAME);
	    	$conn_stat =$db->conn->getAttribute(PDO::ATTR_CONNECTION_STATUS);
			echo "Connected successfully: $driver_name at " . $conn_stat . "<br/>";
			
			$select = $db->conn->prepare('SELECT id, password_hash FROM user WHERE username = ?');
			if (!$select->execute(array($_POST['username']))) {
				throw new Exception("Selhal dotaz SELECT na uživatele " . $_POST['username'], 1003);
			}

			$result=$select->fetch(PDO::FETCH_ASSOC);
			if (!$result) {
				echo "<br/></div><div class=\"main-warning\">Uživatel ". $_POST['username'] . " nemá oprávnění užívat tento systém. Prosím, zkontrolujte své přihlašovací údaje.</div>";
			} else {
				echo '<div class="system-report">';
				print_r($result);
				echo  "<br/><br/>";
				$password_change="new";
				if(strpos($result['password_hash'], '$$')=== 0) {
					if(strlen($result['password_hash'])==2)
					{
						// TODO: $hash= default password 
					} else {
						$hash=substr($result['password_hash'],2);
					}
//								echo "TODO: verify password and eventually rehash";
				}
				echo "</div>\n";
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
				</form>
			
EOT;
			}
			break;
			
			
		case 'INITIAL':
//			echo '<button type="button" onclick="reloadIndex()">OK</button>';
?>
<div class="main-box">
		<!-- <form action="/Login/login.php" method="post"> -->
		<form action="/index.php" method="post">
<?php
			if(array_key_exists("user_id", $_SESSION)) { ?>
				SESSION_USER_ID = <?php echo $_SESSION["user_id"]; ?><br/><br/>
				<button type="submit" name="action" value="CLEAR">Odhlášení</button>
<?php } else { ?>
				<div class="to-be-centred">Prosím, přihlaste se:</div>
				
				<div class="login-rows">
					<table>
						<tr>
							<td><label for="username">Uživatel:</label></td>
							<td><label for="password">Heslo:</label></td>
						</tr>
						<tr>
							<td><input type="text" name="username" /></td>
							<td><input type="text" name="password" /></td>
						</tr>
					</table>
				</div>
				<div class="to-be-centred">
					<button type="submit" name="action" value="LOGIN">Přihlášení</button>
					<button type="submit" name="action" value="test">Test</button>
				</div>
<?php
			}
?>
		</form>
	</div>
<?php	
		break;
		
	echo "</div></div>\n";
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
<?php
	}
// --- PAGE CODE END ---
	include "../Tools/footer.html";
	ob_end_flush();
} catch (Exception $e) {
	ob_end_clean();
	include $_SERVER[DOCUMENT_ROOT] . "/Tools/exception_report.php";
}
?>	
