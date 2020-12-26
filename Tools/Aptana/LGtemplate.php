<?php
// --- PREAMBLE CODE ---
session_start();
ob_start();
try {
	include $_SERVER[DOCUMENT_ROOT] . "/Tools/header.php";
	$h = new Header;
	unset($h);
// --- PAGE CODE START ---
?>









<?php
// --- PAGE CODE END ---
// --- POSTAMBLE CODE ---
	include "../Tools/footer.html";
	ob_end_flush();
} catch (Exception $e) {
	ob_end_clean();
	include $_SERVER[DOCUMENT_ROOT] . "/Tools/exception_report.php";
}
?>