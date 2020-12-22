<?php
// --- PREAMBLE CODE ---
session_start();
ob_start();
try {
// --- PAGE CODE START ---
?>



<?php
// --- PAGE CODE END ---
	ob_end_flush();
} catch (Exception $e) {
	ob_end_clean();
	include $_SERVER[DOCUMENT_ROOT] . "/Tools/exception_report.php";
}
?>