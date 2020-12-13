
<?php
//echo '<script src="' . getcwd() . '/Structure/hide_boss_container.js"></script>';
echo '<script src="/Structure/hide_boss_container.js"></script>';

date_default_timezone_set('Europe/Prague');

$sql = 'SELECT * FROM structure WHERE boss=:boss ORDER BY id';

class TeamMember
{
	public $id;
	public $name;
	public $surname;
	public $boss;
	
    public function bossElement($last) {
// ****** IMPORTANT: See the following: ********
// https://stackoverflow.com/questions/17498855/svg-polygon-points-with-percentage-units-support
		    echo <<<EOT
<div class="boss-segment">		    
<div class="boss-lines">
   <svg height="1em" width="1em" viewBox="0 0 100 100" 
      preserveAspectRatio="none" style="position:absolute"> 
      <polyline points="50,0 50,50 100,50" style="fill:none;stroke:black;stroke-width:2" vector-effect="non-scaling-stroke"/> 
   </svg>
EOT;


 		if(!$last) {
//        echo 'f';
		echo <<<EOT
   <svg height="100%" width="100%" viewBox="0 0 100 100" 
      preserveAspectRatio="none" style="position:absolute"> 
      <polyline points="50,0 50,100" style="fill:none;stroke:black;stroke-width:2" vector-effect="non-scaling-stroke"/> 
   </svg>
EOT;
     	}
		echo "</div>\n";
		echo <<<EOT
<div class="lines-box"><div class="name-row">
	<div class="collapse-expand" onmouseover="this.style.backgroundColor='grey';this.style.color='white';" onmouseout="this.style.backgroundColor='';this.style.color='';"
	onload="set_svg(this, true)"; 
	onclick="hide_boss_container(this)";>
	<svg height="1em" width="1em" viewBox="0 0 100 100" 
      preserveAspectRatio="none" style="position:absolute">
      <polygon points="5,60 65,60 35,20" style="fill:black" />
      
    </svg>
	</div>
	<div class="member-name" onmouseover="this.style.backgroundColor='grey';this.style.color='white';" onmouseout="this.style.backgroundColor='';this.style.color='';" 
	>$this->name $this->surname\x20</div>
	</div>
EOT;

		TeamMember::bossContainer($this->id);

		echo <<<EOT
</div></div>
EOT;

		
	}	

	
	public static function bossContainer($id) { 
		global $stmt;
			
	    echo <<<EOT
<div class="boss-container">
EOT;

		$stmt->bindValue(':boss', $id, PDO::PARAM_INT);
		$stmt->execute();
		$arr = $stmt->fetchAll(PDO::FETCH_CLASS, 'TeamMember');
	
		$i=1;
		$len=count($arr);
		foreach($arr as $item) { 
			$item->bossElement(($i++) >= $len);
		}
	
	
	    echo <<<EOT
</div>
EOT;
					
	}
} // TeamMember
	
function placeBossContainer($id, $conn) {
	global $sql, $stmt;
	
try {
	$stmt = $conn->prepare($sql);
	
	TeamMember::bossContainer($id);
    }
catch(PDOException $e)
    {
    echo "SQL failed: " . $e->getMessage();
    }
}
?>