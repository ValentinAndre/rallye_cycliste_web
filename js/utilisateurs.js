/* Module de gestion des utilisateurs */

/* Déclaration des objets principaux */
var info, erreur;
var aCloner;
var tbd;

// Ajoute une ligne d'un utilisateur dans le tableau
function addLine(utilisateur) {
	var nouv = aCloner.clone(true);
	var tds = nouv.children();
	tds.eq(0).text(utilisateur.login);
	tds.eq(1).text(utilisateur.mdp);
	
	var btn = nouv.eq(2).children().eq(0);
	btn.click(function() {
		supprimer(nouv, utilisateur.login);
	});

	nouv.appendTo(tbd);
}

//Supprime un utilisateur
function supprimer(jQtr, login) {

	var postData = {
		action : 'delete',
		'class' : 'Utilisateur',
		dao : 'UtilisateursDAO',
		login : login
	};
	
	$.post('php/crud.php', postData, function(data) {
		if (data) {
			jQtr.remove();
			displayMessage(false, "L'utilisateur a bien été supprimé !");
		} else
			displayMessage(true, "L'utilisateur n'a pas été supprimé !");
	}, 'json');

	inputs[0].focus();
}

// Chargement des utilisateurs et affichage dans la table
function loadUtilisateurs() {
	var postData = {
		action : 'retrieveAll',
		'class' : 'Utilisateurs',
		dao : 'UtilisateursDAO'
	};

	$.post("php/crud.php", postData, function(liste) {
		for (i in liste) {
			addLine(liste[i]);
		}
	}, 'json');
}

// Affiche un message d'erreur ou d'information en bas de la page
function displayMessage(error, msg) {
	if (error) {
		info.hide();
		erreur.empty().append(msg).show();
	} else {
		erreur.hide();
		info.empty().append(msg).show();
	}
}

$(document).ready(function() {
	aCloner = $('table > tfoot > tr:last-child');
	tbd = $('table > tbody');
	info = $('#info');
	erreur = $('#erreur');
	
	info.hide();
	erreur.hide();

	loadUtilisateurs();
});
