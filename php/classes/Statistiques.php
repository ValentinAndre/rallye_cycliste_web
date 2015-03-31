<?php
class Statistiques {
	protected $pdo;
	
	public function __construct($pdo) {
		$this->pdo = $pdo;
	}
	
	/* 
	 * Donne le nombre d'inscriptions total
	 * @return : un entier
	 */
	public function getEffectifTotal() {
		$stmt = $this->pdo->query("SELECT COUNT(*) AS effectif FROM INSCRIPTIONS");		
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row['effectif'];	
	}
	
	/*
	 * Donne le nombre d'inscriptions par type de parcours
	 * @return : un tableau associatif (type parcours => effectif)
	 */
	public function getEffectifParParcours() {
		$res = array();
		$stmt = $this->pdo->query("select type, count(*) as effectif from INSCRIPTIONS join PARCOURS on parcours=idParcours group by parcours");
		foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
			$res[$row['type']] = $row['effectif'];
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
			
	public function getYoungest($sexe) {
		$stmt = $this->pdo->prepare("select TIMESTAMPDIFF(YEAR, dateNaissance, CURDATE()) as age from INSCRIPTIONS Where sexe=? order by age ASC  limit 1");
		$stmt->execute(array($sexe));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row['age'];	
	}
}
?>