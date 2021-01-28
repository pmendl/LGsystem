<?php
// --- PREAMBLE CODE ---
try {
	require $_SERVER[DOCUMENT_ROOT] . "/Tools/header.php";
	$h = new Header;
	// eventual parameters for header goes here 
	unset($h);
	require $_SERVER[DOCUMENT_ROOT] . "/Crypto/anti_csrf.php"
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