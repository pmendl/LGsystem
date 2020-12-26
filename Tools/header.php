<?php

class Header
{
	 
	public $title = "Lucky Goo internal system";
	public $charset = "UTF-8";
	
	function addCss($s)
	{
//		echo "$s";
		foreach (self::gen($s) as $value) {
//			echo "<p>Value = $value</p>";
			echo "		<link rel=\"stylesheet\" type=\"text/css\" href=\"/CSS/$value.css\">\n";
		}
	}
	
	function addText($s)
	{
			foreach (self::gens($s) as $value) {
			echo $value;
		}
		
	}
	function setTitle(string $s)
	{
		$this->title = $s;
	}
	
	function setCharset(string $s)
	{
		$this->charset=$s;
	}
	
	function __construct()
	{
		echo <<<EOT
<!DOCTYPE html>
<html>
   	<head>

EOT;
	
	$this->addCss("page_layout");
	$this->addCss(preg_replace(['/\..*$/','/^.*\//'], '', debug_backtrace(1)[0]['file']));
	echo "<!-- HEADER CONSTRUCTOR END -->\n";
	}
	
	function __destruct()
	{
		echo <<<EOT
		
		<meta charset=$this->charset>
  		<title>$this->title</title>
	</head>
	<body>
	
<div class="super-outer-box">
EOT;
	echo "\n<!-- HEADER DESTRUCTOR END -->";

	}
	
	protected static function gen($p)
	{

//		echo "<p>Found ".gettype($p).": $p</p>";
		 
		if(gettype($p) == "string") {
//			echo "<p>Found string: $p</p>"; 
			yield $p;
		}
		
		if(is_array($p)) {
//			echo "<p>It is array</p>"; 
  			yield from $p;
		}
		
		

	}

}
?>