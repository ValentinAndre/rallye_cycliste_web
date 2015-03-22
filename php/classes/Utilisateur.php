<?php
class Utilisateur extends TableObject {
	
	static public $keyFieldsNames = array('login'); // par défaut un seul champ
	public $hasAutoIncrementedKey = false;
	
    public function __tostring() {
         return "$this->login, $this->mdp";
    }
}
?>
