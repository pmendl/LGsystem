<?php
 switch ($_POST['action']) {
 	case 'test':
 		echo "TEST ONLY";
		break;
		
	case 'LOGIN':		
		include "Login/login.php";
		break;
		
	default:
		$_POST['action'] = "INITIAL";
		include "Login/login.php";
 }
?>


