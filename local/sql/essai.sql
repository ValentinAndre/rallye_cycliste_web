/*
 * JEU D'ESSAI
 */

INSERT INTO PARCOURS (idParcours, distance, type) VALUES 
(NULL, 15, 'VTT'),
(NULL, 25, 'VTT'),
(NULL, 40, 'VTT'),
(NULL, 50, 'VTT'),
(NULL, 30, 'ROUTE'),
(NULL, 60, 'ROUTE'),
(NULL, 85, 'ROUTE'),
(NULL, 95, 'ROUTE'),
(NULL, 110, 'ROUTE'),
(NULL, 120, 'ROUTE');

/* Mots de passe en md5 */
INSERT INTO UTILISATEURS (login, mdp) VALUES 
('admin', '21232f297a57a5a743894a0e4a801fc3 '),
('benevole1', '168f6b25335dd80cd88bfd27889630bf'),
('benevole2', '168f6b25335dd80cd88bfd27889630bf'),
('benevole3', '168f6b25335dd80cd88bfd27889630bf');

INSERT INTO PREINSCRIPTIONS (idPreInscription, estArrive, nom, prenom, sexe, dateNaissance, federation, clubOuVille, departement, parcours, inscriveur) VALUES
(NULL, 'false', 'FAVIER', 'MARC', 'F', '1986-06-18', 'NL', 'ZSTPERAY', 7, 1, 'user1@mail.com'),
(NULL, 'false', 'TAILLEFER', 'THOMAS', 'H', '1974-04-01', 'NL', 'ZROMANS', 26, 4, 'user1@mail.com'),
(NULL, 'false', 'WEIL', 'SEBASTIEN', 'H', '1964-07-17', 'NL', 'ZBOFFRES', 7, 5, 'user1@mail.com'),
(NULL, 'false', 'THEOBALD', 'JULES', 'H', '1999-02-09', 'NL', 'ZVALENCE', 26, 1, 'user2@mail.com'),
(NULL, 'false', 'CORNU', 'LUCIE', 'F', '1961-07-12', 'FSGT', 'CCSTPERAY', 7, 2, 'user3@mail.com'),
(NULL, 'false', 'POSSIBLE', 'KIM', 'F', '1990-06-08', 'NL', 'ZTOULAUD', 7, 3, 'user3@mail.com');
								
INSERT INTO INSCRIPTIONS (idInscription, estArrive, nom, prenom, sexe, dateNaissance, federation, clubOuVille, departement, parcours, inscriveur) VALUES
(NULL, 'false', 'TRUCHET', 'SEBASTIEN', 'F', '1986-06-18', 'NL', 'ZSTPERAY', 7, 1, 'benevole1'),
(NULL, 'false', 'TALIERCIO', 'VICTOR', 'H', '1974-04-01', 'NL', 'ZROMANS', 26, 4, 'benevole1'),
(NULL, 'false', 'BLACHON', 'PIERRE', 'H', '1964-07-17', 'NL', 'ZBOFFRES', 7, 5, 'benevole1'),
(NULL, 'false', 'DURET', 'SEBASTIEN', 'H', '1999-02-09', 'NL', 'ZVALENCE', 26, 1, 'benevole1'),
(NULL, 'false', 'GUILLOT', 'JULIETTE', 'H', '1961-07-12', 'FSGT', 'CCSTPERAY', 7, 2, 'benevole1'),
(NULL, 'false', 'CANU', 'GILLES', 'H', '1990-06-08', 'NL', 'ZTOULAUD', 7, 3, 'benevole1'),
(NULL, 'false', 'SAIVE', 'JULES', 'F', '1985-12-13', 'NL', 'ZSTPERAY', 7, 6, 'benevole1'),
(NULL, 'false', 'DERIVAZ', 'GERARD', 'F', '1980-11-08', 'NL', 'ZSTPERAY', 7, 7, 'benevole1'),

(NULL, 'false', 'BOUMAHRAT', 'PHILIPPE', 'H', '1964-10-13', 'NL', 'ZBOURGLESVALENCE', 26, 1, 'benevole2'),
(NULL, 'false', 'BERTHIAUD', 'THEO', 'F', '1968-04-23', 'NL', 'ZGRANGES', 7, 2, 'benevole2'),
(NULL, 'false', 'PARAT', 'VIRGINIE', 'F', '1984-03-23', 'NL', 'ZSTPERAY', 7, 3, 'benevole2'),
(NULL, 'false', 'MAISONNEUVE', 'GUILLAUME', 'H', '1969-01-30', 'NL', 'ZGRANGES', 7, 4, 'benevole2'),
(NULL, 'false', 'BOSSARD', 'YLANN', 'H', '1945-03-20', 'FFC', 'VTTARDBIKE', 26, 5, 'benevole2'),
(NULL, 'false', 'CROUZET', 'ROLAND', 'H', '1980-04-18', 'NL', 'ZSTPERAY', 7, 1, 'benevole2'),
(NULL, 'false', 'CURINIER', 'AXEL', 'H', '1980-05-03', 'NL', 'ZSTPERAY', 7, 3, 'benevole2'),
(NULL, 'false', 'ANDREO', 'BERTRAND', 'H', '1948-06-09', 'FFCT', 'BARBIERESLOISIRS', 26, 7, 'benevole2'),
(NULL, 'false', 'DEFAY', 'GILLES', 'H', '1966-05-16', 'NL', 'ZCHATEAUNEUFSURISERE', 26, 6, 'benevole2'),

(NULL, 'false', 'DARGERE', 'TONIN', 'H', '1973-09-13', 'NL', 'ZROMANS', 26, 8, 'benevole3'),
(NULL, 'false', 'PRADON', 'RAPHAEL', 'H', '1969-07-01', 'NL', 'ZGRANGES', 7, 9, 'benevole3'),
(NULL, 'false', 'LENOIR', 'YVAN', 'F', '1988-10-21', 'NL', 'ZTAIN', 26, 10, 'benevole3'),
(NULL, 'false', 'LAURENT', 'PHILIPPE', 'H', '1967-02-24', 'NL', 'ZCORNAS', 7, 4, 'benevole3'),
(NULL, 'false', 'REIG', 'LAURENT', 'H', '1969-07-16', 'NL', 'ZGRANGES', 7, 3, 'benevole3');