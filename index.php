<?php
 switch ($_POST['action']) {
 	case 'test':
 		require $_SERVER[DOCUMENT_ROOT] . "/Tools/header.php";
		$h = new Header;
		require $_SERVER[DOCUMENT_ROOT] . "/Crypto/anti_csrf.php";
 		echo "TEST ONLY<br/>$_POST[password] -> ";
		if(AntiCsrf::checkToken($_POST['password'])) {
			echo "O.K.<br/>";
		} else {
			echo "FAILED<br/>";
		}
		
		break;
		
	case 'LOGIN':		
		include "Login/login.php";
		break;
		
	default:
		$_POST['action'] = "INITIAL";
		$_SESSION[login_not_earlier] = time();
		include "Login/login.php";
 }
?>


