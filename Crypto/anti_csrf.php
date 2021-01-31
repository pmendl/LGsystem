<?php
	class AntiCsrf {
		
		static private $prev_anti_csrf;
		
		static function init() {
			self::$prev_anti_csrf = $_SESSION['anti_csrf']; 
			$_SESSION['anti_csrf'] = bin2hex(random_bytes(8));
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
