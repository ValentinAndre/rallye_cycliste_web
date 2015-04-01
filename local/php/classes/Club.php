<?php
class Club extends TableObject {
	
	static public $keyFieldsNames = array('clubOuVille'); // par défaut un seul champ
	public $hasAutoIncrementedKey = false;
	
	public $fields;
	
	public function __construct($fields) {
		$this->fields = $fields;
	}
	public function toTableRow() {
		echo "<tr>";
		foreach($this->fields as $key => $value)
			echo "<td>", $value, "</td>";
		echo "</tr>\n";
	}
}
?>
