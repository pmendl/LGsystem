<?php
// --- PREAMBLE CODE ---
try {
	require $_SERVER['DOCUMENT_ROOT'] . "/Tools/header.php";
	$h = new Header;
	$h->setSubtitle("Přihlášení uživatele");
	unset($h);
	include_once $_SERVER['DOCUMENT_ROOT'] . "/Crypto/anti_csrf.php";
	
// --- PAGE CODE START ---
//	print_r($_POST);
?>
	<script>
		function reloadIndex() { console.log("Zrušit clicked"); window.location.assign("/"); }
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

	<div class="main-box">
		<div class="system-report">

<?php

	if(isset($_SESSION['login_not_earlier']) && (time() < $_SESSION['login_not_earlier'])) {
		time_sleep_until ($_SESSION['login_not_earlier']);
	}
	$_SESSION['login_not_earlier'] = time() + 3; // TODO: Separate "3" to named constants
	print_r($_POST);
	echo "<br/>";
	switch ($_POST['action']) {
		case 'LOGOUT':
			unset($_SESSION["user_id"]);
			echo "LOGOUT done !!!<br/>";
		case 'LOGIN':
			if(!AntiCsrf::checkToken($_POST['anti-csrf'])) {
				throw new Exception("Invalid antiCSRF token", 6001);
			}
			require(__DIR__ . "/../Tools/database.php");
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
				echo  "<br/>";
				$password_change="NEW";
				if(strpos($result['password_hash'], '$$')=== 0) {
					if(strlen($result['password_hash'])==2)
					{
						echo 'TODO: $hash= default password'; 
					} else {
						$hash=substr($result['password_hash'],2);
					}
					echo 'TODO: verify password and eventually rehash';
				}
				include 'password_change.php';
				echo "<br/></div>\n";
			}
			break;
			
			
		case 'INITIAL':
//			echo '<button type="button" onclick="reloadIndex()">OK</button>';
			echo "INITIAL CASE";
?>
<div class="main-box">
		<!-- <form action="/Login/login.php" method="post"> -->
		<form action="/index.php" method="post">
			<input type="hidden" id="anti-csrf" name="anti-csrf" value="">
<?php
//			<input type="hidden" id="anti-csrf" name="anti-csrf" value="<?php echo AntiCsrf::getToken()">
			if(array_key_exists("user_id", $_SESSION)) { ?>
				SESSION_USER_ID = <?php echo $_SESSION["user_id"]; ?><br/><br/>
				<button type="submit" name="action" value="LOGOUT">Odhlášení</button>
<?php 		} else { ?>
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
	}
// --- PAGE CODE END ---
	include $_SERVER['DOCUMENT_ROOT'] . "/Tools/footer.html";
	ob_end_flush();
} catch (Exception $e) {
	ob_end_clean();
	include $_SERVER['DOCUMENT_ROOT'] . "/Tools/exception_report.php";
}
?>	
