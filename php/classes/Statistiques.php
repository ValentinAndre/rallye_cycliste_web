<?php
class Statistiques {
	protected $pdo;
	
	public function __construct($pdo) {
		$this->pdo = $pdo;
	}
	
	/* 
	 * Donne le nombre d'inscriptions total
	 * @params : un complément de requête SQL ou un type de parcours
	 * @return : un entier
	 */
	public function getEffectif($complementRequete = "") {
		$stmt = $this->pdo->query("SELECT COUNT(*) AS effectif FROM INSCRIPTIONS $complementRequete");		
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row['effectif'];	
	}

	/*
	 * Donne le nombre d'inscriptions par parcours
	 * @param : un type de parcours
	 * @return : un tableau associatif (distance => effectif)
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
	 * Donne la répartition des inscriptions par club
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
		
		$stmt = $this->pdo->query("SELECT COUNT(*) as effectif FROM INSCRIPTIONS WHERE clubOuVille='$club' AND TIMESTAMPDIFF(YEAR, dateNaissance, CURDATE()) < 19");				
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$fields['effectifMineurs'] = $row['effectif'];
		
		return new Club($fields);
	} 
}
?>