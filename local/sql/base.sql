/* 
 * CREATION DE LA BASE DE DONNEES
 */

CREATE TABLE UTILISATEURS (
	login VARCHAR (50) UNIQUE NOT NULL,
	mdp CHAR(32),
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
	inscriveur VARCHAR (50),
	PRIMARY KEY (idInscription)
) ENGINE=InnoDB;

CREATE TABLE PREINSCRIPTIONS (
	idPreInscription int(11) NOT NULL AUTO_INCREMENT,
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
	PRIMARY KEY (idPreInscription)
) ENGINE=InnoDB;

ALTER TABLE INSCRIPTIONS
  ADD CONSTRAINT inscription_1 FOREIGN KEY (parcours) REFERENCES PARCOURS (idParcours),
  ADD CONSTRAINT inscription_2 FOREIGN KEY (inscriveur) REFERENCES UTILISATEURS (login);