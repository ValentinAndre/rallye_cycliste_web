<?php
class Club extends TableObject {
	
	static public $keyFieldsNames = array('clubOuVille'); // par défaut un seul champ
	public $hasAutoIncrementedKey = false;
	
	public function toTableRow() {
		echo "<tr>";
		foreach($this->getFieldsValuesWithoutKey() as $value)
			echo "<td>", $value, "</td>";
		echo "</tr>\n";
	}
}
?>
