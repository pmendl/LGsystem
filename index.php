<?php
	session_start();
?>

<!DOCTYPE html>
<html>
   	<head>
      <meta charset="UTF-8">
      
      <title>Lucky Goo internal system</title>

		<link rel="stylesheet" type="text/css" href="/CSS/page_layout.css">
		<link rel="stylesheet" type="text/css" href="/CSS/login.css">
	
	</head>
<body>

<div class="super-outer-box">
	<div class="header-footer">
		LUCKY GO System
	</div>
	
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
				</div>
 		<?php
			}
		?>
		</form>
	</div>

	<script language="javascript" type="text/javascript" src="/Tools/footer.js"></script>

</div>

</body>
</html> 