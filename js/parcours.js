/*
 * Module de gestion de la page des parcours 
 */

/* Déclaration des objets principaux */
var aCloner;
var tbd;

/*
 * Ajoute un parcours dans une ligne du tableau
 * Paramètre : un parcours (JSON Object)
 */
function addLine(parcours) {
	var nouv = aCloner.clone(true);
	var tds = nouv.children();
	tds.eq(0).text(parcours.idParcours);
	tds.eq(1).text(parcours.distance);
	tds.eq(2).text(parcours.type);	

	nouv.appendTo(tbd);
}

/*
 * Chargement des parcours dans le tableau
 */
function loadParcours() {
	var postData = {
		action : 'retrieveAll',
		'class' : 'Parcours',
		dao : 'ParcoursDAO'
	};

	$.post("php/crud.php", postData, function(liste) {
		for (i in liste) {
			addLine(liste[i]);
		}
	}, 'json');
}

$(document).ready(function() {
	aCloner = $('table > tfoot > tr:last-child');
	tbd = $('table > tbody');

	loadParcours();
});
