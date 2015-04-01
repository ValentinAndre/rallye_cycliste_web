<?php
class Statistiques {
	protected $pdo;
	
	public function __construct($pdo) {
		$this->pdo = $pdo;
	}
	
	/* 
	 * Donne le nombre total d'inscriptions
	 * @params : un complément de requête SQL
	 * @return : un entier
	 */
	public function getEffectif($complementRequete = "") {
		$stmt = $this->pdo->query("SELECT COUNT(*) AS effectif FROM INSCRIPTIONS $complementRequete");		
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row['effectif'];	
	}

	/*
	 * Donne le nombre d'inscriptions par parcours (distance)
	 * @param : un type de parcours
	 * @return : un tableau associatif (parcours (distance) => effectif)
	 */
	public function getEffectifParParcours($type) {
		$res = array();
		$stmt = $this->pdo->prepare("SELECT COUNT(*) AS effectif, distance FROM INSCRIPTIONS JOIN PARCOURS ON PARCOURS.idParcours=INSCRIPTIONS.parcours WHERE type=? GROUP BY distance");
		$stmt->execute(array($type));
		foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
			$res[$row['distance']] = $row['effectif'];
		}
		return $res;
	}
	
	/*
	 * Donne le club avec le plus grand effectif
	 * @param : un complément de requête SQL
	 * @return : un tableau associatif d'un élément (clubOuVille => effectif)
	 */
	public function getClubMax($complementRequete = "") {
		$stmt = $this->pdo->query("SELECT clubOuVille, COUNT(*) AS effectif FROM INSCRIPTIONS JOIN PARCOURS ON parcours=idParcours
								   WHERE federation <> 'NL' $complementRequete GROUP BY clubOuVille HAVING effectif=
								  (SELECT MAX(effectif) FROM (SELECT COUNT(*) AS effectif FROM INSCRIPTIONS JOIN PARCOURS ON parcours=idParcours
								  WHERE federation <> 'NL' $complementRequete GROUP BY clubOuVille) AS sr)");
		
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row;
	}
	
	/*
	 * Donne les plus jeunes participants d'un type de parcours et d'un sexe donné
	 * @param : un type de parcours, un sexe et un entier (optionnel)
	 * @return : un tableau associatif (nom, prenom, age)
	 */
	public function getYounger($type, $sexe, $number = 5) {
		$stmt = $this->pdo->query("SELECT nom, prenom, TIMESTAMPDIFF(YEAR, dateNaissance, CURDATE()) AS age
								   FROM INSCRIPTIONS JOIN PARCOURS ON idParcours=parcours
								   WHERE type='$type' AND sexe='$sexe' ORDER BY dateNaissance DESC LIMIT $number");
		
		foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
			$res['nom'] = $row['nom'];
			$res['prenom'] = $row['prenom'];
			$res['age'] = $row['age'];
		}
		return $res;		
	}
	
	/*
	 * Donne la répartition des inscriptions sur plusieurs critères par club
	 * @return : un tableau de Clubs (TableObject)
	 */
	public function getClubs() {
		$res = array();
		$stmt = $this->pdo->query("select clubOuVille from INSCRIPTIONS WHERE federation <> 'NL'");
		foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
			$res[] = $this->getClub($row['clubOuVille']);
		}
		return $res;
	}
	
	/*
	 * Récupère toutes les statistiques sur un club
	 * @return : un Club (TableObject)
	 */
	private function getClub($club) {
		$fields['nomClub'] = $club;
		
		$stmt = $this->pdo->query("SELECT COUNT(*) AS effectif, departement FROM INSCRIPTIONS WHERE clubOuVille='$club'");
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$fields['departement'] = $row['departement'];
		$fields['effectifTotal'] = intval($row['effectif']);		
		
		$stmt = $this->pdo->query("SELECT COUNT(*) AS effectif FROM INSCRIPTIONS WHERE clubOuVille='$club' AND sexe='H'");	
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$fields['effectifHommes'] = intval($row['effectif']);
		$fields['effectifFemmes'] = $fields['effectifTotal'] - $fields['effectifHommes'];
		
		$stmt = $this->pdo->query("SELECT COUNT(*) as effectif FROM INSCRIPTIONS WHERE clubOuVille='$club' 
								   AND TIMESTAMPDIFF(YEAR, dateNaissance, CURDATE()) < 19");
						
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$fields['effectifMineurs'] = $row['effectif'];
		
		return new Club($fields);
	} 
}
?>