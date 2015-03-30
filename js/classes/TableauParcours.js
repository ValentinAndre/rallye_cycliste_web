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
	 * Donne le nom d'un parcours à partir d'un indice
	 * @param : un entier
	 * @return : une chaine
	 */
	this.getName = function(indice) {
		if (indice >= 0 && indice < this.parcours.length)
			return this.parcours[indice].type + this.parcours[indice].distance;
		else
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