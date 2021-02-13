<?php
 
	class AntiCsrf {
		
		static private $prev_anti_csrf;
		
		static function init() {
			if (isset($_SESSION['anti_csrf'])) {
				self::$prev_anti_csrf = $_SESSION['anti_csrf']; 
				$_SESSION['anti_csrf'] = bin2hex(random_bytes(8));
			} else {
				self::$prev_anti_csrf = "";
			}
		}
	
		static function getToken() {
			return $_SESSION['anti_csrf'];
		}
		
		static function checkToken($response) {
			return ($response === self::$prev_anti_csrf);
		}
		
	}
	
	AntiCsrf::init();
 
?>