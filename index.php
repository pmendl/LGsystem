<?php
// --- PREAMBLE CODE ---
session_start();
ob_start();
try {
	include $_SERVER[DOCUMENT_ROOT] . "/Tools/header.php";
	$h = new Header;
	$h->addCss("login");
	unset($h);
// --- PAGE CODE START ---
?>
	<div class="system-report">
		<?php
			echo "Include path = " . get_include_path();
		?>
	</div>
 
	<div class="main-box">
		<form action="/Login/login.php" method="post">
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
				</div>
<?php
			}
?>
		</form>
	</div>
<?php
// --- PAGE CODE END ---
	include "Tools/footer.html";
	ob_end_flush();
} catch (Exception $e) {
	ob_end_clean();
	include $_SERVER[DOCUMENT_ROOT] . "/Tools/exception_report.php";
}
?>


