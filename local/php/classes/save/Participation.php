<?php
class Participation {
	
	private $total;
	private $fields;
	
	public function __construct($fields, $total) {		
		$this->fields = $fields;
		$this->total = $total;
	}
	
	public function toTableContent() {
		echo "<thead><tr><th>TOTAL</th><th>", $this->total, "</th><th></th></tr></thead>";		
		echo "<tbody>";
		foreach($this->fields as $key => $value) {
			if ($key === "total")
				continue;
			$pourcentage = ($value / $this->total) * 100;
			$pourcentage = round($pourcentage, 0);
			echo "<tr><td>", $key, "</td><td>", $value, "</td><td>", $pourcentage, "%</td></tr>";
		}
		echo "</tbody>";
	}
}
?>
