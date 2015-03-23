/* 
 * Module de gestion de la page des inscriptions
 */

/* Déclaration des tableaux globaux */
var federations = [ 'FFC', 'FFCT', 'NL', 'FSGT', 'UFOLEP' ];
var parcours = [];

/* Déclaration des objets principaux */
var info, erreur;
var aCloner;
var tbd;
var inputs;

/*
 * Ajoute une inscription dans une ligne du tableau
 * Paramètre : une inscription (JSON Object)
 */
function addLine(inscription) {
	var nouv = aCloner.clone(true);
	var tds = nouv.children();

	tds.eq(0).text(inscription.nom);
	tds.eq(1).text(inscription.prenom);
	tds.eq(2).text(inscription.sexe);
	tds.eq(3).text(inscription.dateNaissance);
	tds.eq(4).text(inscription.federation);
	tds.eq(5).text(inscription.clubOuVille);
	tds.eq(6).text(inscription.departement);

	tds.eq(7).text(
			parcours[inscription.parcours - 1].type
					+ parcours[inscription.parcours - 1].distance);

	// Paramétrage des boutons
	var btns = tds.eq(8).children();
	btns.eq(0).click(function() {
		copier(inscription);
	});
	btns.eq(1).click(function() {
		supprimer(inscription.idInscription);
	});

	nouv.appendTo(tbd);
}

/*
 * Chargement des fédérations et des parcours dans les selects
 */
function loadSelect() {
	for (i in federations)
		$('#federation').append(new Option(federations[i], federation[i]));

	postData = {
		action : 'retrieveAll',
		'class' : 'Parcours',
		dao : 'ParcoursDAO'
	}

	$.post("php/crud.php", postData, function(liste) {
		for (i in liste) {
			parcours[i] = liste[i];
			$('#parcours').append(
					new Option(liste[i].type + liste[i].distance,
							liste[i].idParcours));
		}
	}, 'json');
}

/*
 * Chargement des inscriptions et affichage dans la table
 */
function loadInscriptions() {
	var postData = {
		action : 'retrieveLastTen',
		'class' : 'Inscription',
		dao : 'InscriptionsDAO',
		inscriveur : inputs[8].val()
	};

	$.post("php/crud.php", postData, function(liste) {
		for (i in liste) {
			addLine(liste[i]);
		}
	}, 'json');
}

// ------- Fonctions de gestion des boutons ------- //

/*
 * Supprime une inscription 
 * Paramètre : id (int) : l'identifiant de l'inscription
 */
function supprimer(id) {
	var postData = {
		action : 'delete',
		'class' : 'Inscription',
		dao : 'InscriptionsDAO',
		idInscription : id
	};

	$.post('php/crud.php', postData, function(data) {
		if (data) {
			tbd.empty();
			loadInscriptions();
			displayMessage(false, "L'inscription a bien été supprimée !");
		} else
			displayMessage(true, "L'inscription n'a pas été supprimée !");
	}, 'json');

	inputs[0].focus();
}

/*
 * Ajoute une inscription
 */
function ajouter() {
	if (checkInputs()) {

		var postData = {
			action : 'create',
			'class' : 'Inscription',
			dao : 'InscriptionsDAO',
			estArrive : false,
			nom : inputs[0].val(),
			prenom : inputs[1].val(),
			sexe : inputs[2].val(),
			dateNaissance : inputs[3].val(),
			federation : inputs[4].val(),
			clubOuVille : inputs[5].val(),
			departement : parseInt(inputs[6].val()),
			parcours : parseInt(inputs[7].val()),
			inscriveur : inputs[8].val()
		};

		$.post("php/crud.php", postData, function(data) {
			if (data === false) {
				displayMessage(true, "L'inscription n'a pas été ajoutée !");
			} else {
				// on supprime la première ligne du tableau
				if (tbd.children().size() > 9)
					$('table > tbody > tr:first-child').remove();

				addLine(data);
				$('form').trigger("reset");
				displayMessage(false, "L'inscription a bien été ajoutée !");
			}
		}, 'json');

	} else
		displayMessage(true, "La saisie n'est pas valide !");

	inputs[0].focus();
}

/*
 * Copie une ligne du tableau dans les champs à saisir
 * Paramètre : une inscription (JSON Object)
 */
function copier(inscription) {
	inputs[0].val(inscription.nom);
	inputs[1].val(inscription.prenom);
	inputs[2].val(inscription.sexe);
	inputs[3].val(inscription.dateNaissance);
	inputs[4].val(inscription.federation);
	inputs[5].val(inscription.clubOuVille);
	inputs[6].val(inscription.departement);
	inputs[7].val(inscription.parcours);

	displayMessage(false, "L'inscription a bien été copiée !");
	inputs[0].focus();
}

// ------- Fonctions diverses ------- //

/*
 * Affiche un message d'erreur ou d'information en bas de la page
 * Paramètres :
 * - error (boolean) : vrai si il s'agit d'une erreur
 * - msg (string) : le message à afficher
 */
function displayMessage(error, msg) {
	if (error) {
		info.hide();
		erreur.empty().append(msg).show(300);
	} else {
		erreur.hide();
		info.empty().append(msg).show(300);
	}
}

/*
 * Vérifie les informations saisies par l'utilisateur
 */
function checkInputs() {
	// On vérifie qu'il n'y a pas de champ vide
	for (i = 0; i < 8; i++) {
		if (inputs[i].val().length == 0)
			return false;
	}
	// On vérifie la date (AAAA-MM-JJ)
	var date_arr = inputs[3].val().split('-');
	d = new Date(date_arr[0], parseInt(date_arr[1]) - 1, date_arr[2]);
	if (d.getFullYear() != date_arr[0]
			|| parseInt(d.getMonth()) + 1 != date_arr[1]
			|| d.getDate() != date_arr[2])
		return false;

	// On vérifie qu'il s'agit bien d'un département
	if (!(inputs[6].val() > 0 && inputs[6].val() < 96))
		return false;

	return true;
}

$(document).ready(
		function() {
			info = $('#info');
			erreur = $('#erreur');
			aCloner = $('table > tfoot > tr:last-child');
			tbd = $('table > tbody');
			// tableau de tous les champs à remplir
			inputs = [ $('#nom'), $('#prenom'), $('#sexe'), $('#date'),
					$('#federation'), $('#clubOuVille'), $('#departement'),
					$('#parcours'), $('#inscriveur') ];

			// on cache les messages par défaut
			erreur.hide();
			info.hide();

			loadSelect();
			loadInscriptions();

			// Définition du click sur valider
			$('#valider').click(function() {
				ajouter();
			});
});