<?php
	session_start();
?>

<!DOCTYPE html>
<html>
   <head>
      <meta charset="UTF-8">
      
      <title>Příjem POST</title>

      <style>
      </style>

	</head>
	<body>TEST:<br/><br/>
		<?php
			var_dump($_POST);
			
			echo nl2br("\n\nSESSION VARIABLES:\n");
			var_dump($_SESSION);
			
			$_SESSION["test"]=$_POST["test"];
		?>
		
	</body>
</html>
		