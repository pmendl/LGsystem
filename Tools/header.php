<?php

class Header
{
	 
	public $title = "LUCKY GO system";
	public $charset = "UTF-8";
	public $subtitle = ''; 
	
	function addCss($s)
	{
		foreach (self::gen($s) as $value) {
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
	
	function setSubtitle(string $s)
	{
		$this->subtitle = $s;
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
	}
	
	function __destruct()
	{
		$page_title = $this->title;
		if($this->subtitle != '') {
			$page_title .= " - $this->subtitle";
		}
		echo <<<EOT
		<meta charset=$this->charset>
  		<title>$this->title</title>
	</head>
	<body>
	
<div class="super-outer-box">
	<div class="header">
		$page_title
	</div>
EOT;
	}
	
	protected static function gen($p)
	{
		if(gettype($p) == "string") {
			yield $p;
		}
		
		if(is_array($p)) {
  			yield from $p;
		}
		
		

	}

}
?>