<?php
	session_start();
?>

<!DOCTYPE html>
<html>
   <head>
      <meta charset="UTF-8">
      
      <title>Registrace klienta</title>

      <style>
      </style>

	</head>
	<body>

<!--
<?php
    phpinfo();
?>
-->
		<?php $session_value=$_SESSION["test"]; ?>
		<form name="registration" method="post" action="receive.php">
			<input type="text" name="test" value=<?php echo "$session_value" ?> />
			<input type="submit" name="phase_1" value="Odeslat"/>
		</form>
	</body>
</html>