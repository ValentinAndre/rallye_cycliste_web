/*
 * Objet représentant un tableau de parcours
 */

function TableauParcours() {

		// Constructeur //
	
	var data = [];
	
	var postData = {
		action : 'retrieveAll',
		'class' : 'Parcours',
		dao : 'ParcoursDAO'
	}
	
	// pour éviter les problèmes d'asynchronisme
	$.ajaxSetup({async:false});

	$.post("php/crud.php", postData, function(liste) {
		for (i in liste) {			
			data[i] = liste[i];
		}
	}, 'json');

	this.parcours = data;
	
		// Méthodes //
	
	/*
	 * Donne le nom d'un parcours à partir d'un id
	 * @param : un entier
	 * @return : une chaine
	 */
	this.getName = function(id) {
		var i = 0;
		while (i < this.parcours.length) {
			if (this.parcours[i].idParcours == id)
				return this.parcours[i].type + this.parcours[i].distance;
			i++; 
		}
		return -1;
	}
	
	/*
	 * Donne le type d'un parcours à partir d'un id
	 * @param : un entier
	 * @return : une chaine
	 */
	this.getType = function(id) {
		var i = 0;
		while (i < this.parcours.length) {
			if (this.parcours[i].idParcours == id)
				return this.parcours[i].type;
			i++;
		}
		return -1;
	}
	
	/*
	 * Donne la distance d'un parcours à partir d'un id
	 * @param : un entier
	 * @return : un entier
	 */
	this.getDistance = function(id) {
		var i = 0;
		while (i < this.parcours.length) {
			if (this.parcours[i].idParcours == id)
				return this.parcours[i].distance;
			i++;
		}
		return -1;
	}
	
	/*
	 * Remplit un select de parcours
	 * @param : un select (objet DOM)
	 */
	this.feedSelect = function(jQselect) {
		for (i=0; i<this.parcours.length; i++)
			jQselect.append(
					new Option(this.parcours[i].type + this.parcours[i].distance,
							this.parcours[i].idParcours));	
	}
}