<?php
class Parcours extends TableObject {

	static public $keyFieldsNames = array('idParcours'); // par défaut un seul champ
	public $hasAutoIncrementedKey = true;
	
    public function __tostring() {
         return "$this->idParcours, $this->distance, $this->type";
    }    
    
    public function toForm() {
    	$selected = ($this->type == "ROUTE") ? "selected" : "";
    	
    	echo '<form class="form-inline vertical-offset-5 center-text" action="', $_SERVER['PHP_SELF'], '" method="post">
              		<div class="form-group">
    					<input type="hidden" value="', $this->idParcours, '" name="id">
    					<select class="form-control input-sm" name="type">
    						<option value="VTT">VTT</option>
   							<option value="ROUTE" ', $selected, '>ROUTE</option>
   						</select>
   						<input class="form-control center-text input-sm" type="text" value="',
   								$this->distance, '" name="distance" placeholder="Distance..." required>';
    	
    	if ($this->idParcours === DAO::UNKNOWN_ID)
    		echo '<button type="submit" class="icon-button" name="add[]">
				  		<span class="glyphicon glyphicon-plus" aria-hidden="true"> </span>
				  </button>';
    	else
    		echo '<button type="submit" class="icon-button" name="modif[]">
				  		<span class="glyphicon glyphicon-pencil" aria-hidden="true"> </span>
				  </button>
    			  <button type="submit" class="icon-button" name="supp[]">
				  		<span class="glyphicon glyphicon-remove" aria-hidden="true"> </span>
				  </button>';
    	
    	echo '</div></form>';
    }
}
?>