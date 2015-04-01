/*
 *	Module du pointage 
 */

/* Déclaration des objets principaux */
var parcours = new TableauParcours();
var couleur = '#A4D0F5';
var aCloner;
var tbd;

/*
 * Ajoute une ligne d'inscription dans le tableau @params : une inscription
 * (JSON Object)
 */
function addLine(inscription) {
	var nouv = aCloner.clone(true);
	var tds = nouv.children();
	tds.eq(0).text(inscription.nom);
	tds.eq(1).text(inscription.prenom);
	tds.eq(2).text(inscription.sexe);
	tds.eq(3).text(inscription.dateNaissance);
	tds.eq(4).text(parcours.getType(inscription.parcours));
	tds.eq(5).text(parcours.getDistance(inscription.parcours));

	if (inscription.estArrive == true) {
		nouv.css('background-color', couleur);
		nouv.click(function() {
			update(nouv, inscription.idInscription, 0);
		});
	} else {
		nouv.click(function() {
			update(nouv, inscription.idInscription, 1);
		});
	}

	nouv.appendTo(tbd);
}

/*
 * Chargement des inscriptions et affichage dans la table
 */
function loadInscriptions() {
	var postData = {
		action : 'retrieveAll',
		'class' : 'Inscription',
		dao : 'InscriptionsDAO'
	};

	$.post("php/crud.php", postData, function(liste) {
		for (i in liste) {
			addLine(liste[i]);
		}
	}, 'json');
}

/*
 * Met à jour le pointage d'un cycliste @params : - jQtr (jQuery Object) : la
 * ligne du tableau contenant l'inscription du cycliste - id (int) :
 * l'identifiant d'inscription du cycliste
 */
function update(jQtr, id, arrive) {
	var postData = {
		action : 'update',
		'class' : 'Inscription',
		dao : 'InscriptionsDAO',
		idInscription : id,
		estArrive : arrive
	};

	if (arrive)
		jQtr.css('background-color', couleur);
	else
		jQtr.css('background-color', "white");

	$.post('php/crud.php', postData, function(data) {
		if (data) {
			// on met à jour les données dans l'événement
			jQtr.off();
			jQtr.click(function() {
				update(jQtr, id, 1 - arrive);
			});
		} else {
			alert("Il y a eu une erreur dans le pointage !");
		}
	}, 'json');
}

$(document).ready(function() {
	aCloner = $('table > tfoot > tr:last-child');
	tbd = $('table > tbody');

	// pour éviter les problèmes d'asynchronisme
	$.ajaxSetup({
		async : false
	});

	loadInscriptions();
	$('table').tablesorter();
});
