<?php
class Inscription extends TableObject {

	static public $keyFieldsNames = array('idInscription'); // par défaut un seul champ
	public $hasAutoIncrementedKey = true;
	
	public function __tostring() {
		return "$this->idInscription, $this->nom, $this->prenom, $this->sexe, $this->dateNaissance, $this->federation, $this->clubOuVille, $this->departement";
	}
	
	public function getAge() {
		$age = date_create($this->dateNaissance)->diff(date_create('today'))->y;
		return $age; 
	}
}
?>
