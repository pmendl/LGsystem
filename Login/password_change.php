<?php
// echo "\$password_change=$password_change <br/>";

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

?>