/* Création de la base de données */

CREATE TABLE UTILISATEURS (
	login VARCHAR (50) UNIQUE NOT NULL,
	mdp VARCHAR(20),
	PRIMARY KEY (login) 
) ENGINE=InnoDB;

CREATE TABLE PARCOURS (
	idParcours int(11) NOT NULL AUTO_INCREMENT,
	distance INT,
	type VARCHAR(5),
	PRIMARY KEY (idParcours) 
) ENGINE=InnoDB;

CREATE TABLE INSCRIPTIONS (
	idInscription int(11) NOT NULL AUTO_INCREMENT,
	estArrive BOOLEAN NOT NULL,
	nom VARCHAR(30),
	prenom VARCHAR(30),
	sexe CHAR(1),
	dateNaissance DATE,
	federation VARCHAR (6),
	clubOuVille VARCHAR (40),
	departement INT,
	parcours int(11) NOT NULL,
	inscriveur VARCHAR (50) NOT NULL,
	PRIMARY KEY (idInscription)
) ENGINE=InnoDB;

/* TODO : Créer une table fédération pour liste déroulante ! */

ALTER TABLE INSCRIPTIONS
  ADD CONSTRAINT inscription_1 FOREIGN KEY (parcours) REFERENCES PARCOURS (idParcours),
  ADD CONSTRAINT inscription_2 FOREIGN KEY (inscriveur) REFERENCES UTILISATEURS (login);
