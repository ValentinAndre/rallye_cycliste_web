<?php
class Parcours extends TableObject {

	static public $keyFieldsNames = array('idParcours'); // par défaut un seul champ
	public $hasAutoIncrementedKey = true;
	
    public function __tostring() {
         return "$this->idParcours, $this->distance, $this->type";
    }    
    
    public function toTableRow(){
    	echo '<tr><td>', $this->idParcours, '</td><td>', $this->distance, '</td><td>', $this->type, '</td></tr>';
    }
    
    public function getFields() {
    	return $this->getAllFields();
    }
}
?>