<?php
class Statistiques {
	protected $pdo;
	public function __construct($pdo) {
		$this->pdo = $pdo;
	}
	
	/*
	 * Donne le nombre d'inscriptions total ou d'un type de parcours
	 * si celui-ci est est spécifié en paramètre
	 * @return : un entier
	 */
	private function getEffectif($parcours = "") {
		if (empty ( $parcours ))
			$stmt = $this->pdo->query ( "SELECT COUNT(*) AS effectif FROM INSCRIPTIONS" );
		else {
			$stmt = $this->pdo->query ( "SELECT COUNT(*) AS effectif FROM INSCRIPTIONS JOIN PARCOURS ON parcours=idParcours WHERE type='$parcours'" );
		}
		$row = $stmt->fetch ( PDO::FETCH_ASSOC );
		return $row ['effectif'];
	}
	
	/*
	 * Donne la répartition des inscriptions par club
	 * @return : un tableau de Clubs (TableObject)
	 */
	public function getClubs() {
		$res = array ();
		$stmt = $this->pdo->query ( "select clubOuVille from INSCRIPTIONS WHERE federation <> 'NL'" );
		foreach ( $stmt->fetchAll ( PDO::FETCH_ASSOC ) as $row ) {
			$res [] = $this->getClub ( $row ['clubOuVille'] );
		}
		return $res;
	}
	
	/*
	 * Récupère toutes les statistiques sur un club
	 * @return : un Club (TableObject)
	 */
	private function getClub($club) {
		$fields ['nomClub'] = $club;
		
		$stmt = $this->pdo->query ( "SELECT COUNT(*) AS effectif, departement FROM INSCRIPTIONS WHERE clubOuVille='$club'" );
		$row = $stmt->fetch ( PDO::FETCH_ASSOC );
		$fields ['departement'] = $row ['departement'];
		$fields ['effectifTotal'] = intval ( $row ['effectif'] );
		
		$stmt = $this->pdo->query ( "SELECT COUNT(*) AS effectif FROM INSCRIPTIONS WHERE clubOuVille='$club' AND sexe='H'" );
		$row = $stmt->fetch ( PDO::FETCH_ASSOC );
		$fields ['effectifHommes'] = intval ( $row ['effectif'] );
		$fields ['effectifFemmes'] = $fields ['effectifTotal'] - $fields ['effectifHommes'];
		
		$stmt = $this->pdo->query ( "SELECT COUNT(*) as effectif FROM INSCRIPTIONS WHERE clubOuVille='$club' AND TIMESTAMPDIFF(YEAR, dateNaissance, CURDATE()) < 19" );
		$row = $stmt->fetch ( PDO::FETCH_ASSOC );
		$fields ['effectifMineurs'] = $row ['effectif'];
		
		return new Club ( $fields );
	}
	
	/*
	 * Récupère les statistiques de participation d'un type de parcours si
	 * il est passé en paramètre sinon les statistiques de participation globale 
	 * @return : une Participation (TableObject)
	 */
	public function getParticipation($parcours = "") {
		if (empty ( $parcours )) {
			$total = $this->getEffectif ();
			foreach ( $this->getEffectifParFederation () as $key => $value )
				$fields [$key] = $value;
			$fields ['Femmes'] = $this->getEffectifFemmes ();
			$fields ['Mineurs'] = $this->getEffectifMineurs ();
		} else {
			$total = $this->getEffectif ($parcours);
			foreach ( $this->getEffectifParFederation ( $parcours ) as $key => $value )
				$fields [$key] = $value;
			$fields ['Femmes'] = $this->getEffectifFemmes ( $parcours );
			$fields ['Mineurs'] = $this->getEffectifMineurs ( $parcours );
		}
		
		return new Participation ( $fields, $total );
	}
	
	/*
	 * Récupère les effectifs de chaque fédération sur un type de parcours si
	 * le paramètre est passé, sinon les effectifs de chaque féfération au total
	 * @return : un tableau associatif (fédération => effectif)
	 */
	private function getEffectifParFederation($parcours = "") {
		$res = array();
		if (empty($parcours))
			$stmt = $this->pdo->query ( "SELECT federation, COUNT(*) as effectif FROM INSCRIPTIONS GROUP BY federation" );
		else
			$stmt = $this->pdo->query ( "SELECT federation, COUNT(*) as effectif FROM INSCRIPTIONS JOIN PARCOURS ON parcours=idParcours WHERE type='$parcours' GROUP BY federation");
		foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $row)
			$res[$row['federation']] = $row['effectif'];
		return $res;
	}
	
	/*
	 * Récupère le nombre de mineurs d'un type de parcours si
	 * le paramètre est passé, sinon le nombre de mineurs au total
	 * @return : un entier
	 */
	private function getEffectifMineurs($parcours = "") {
		if (empty($parcours))
			$stmt = $this->pdo->query ( "SELECT COUNT(*) as effectif FROM INSCRIPTIONS WHERE TIMESTAMPDIFF(YEAR, dateNaissance, CURDATE()) < 19" );
		else
			$stmt = $this->pdo->query ( "SELECT COUNT(*) as effectif FROM INSCRIPTIONS JOIN PARCOURS ON parcours = idParcours WHERE type='$parcours' AND TIMESTAMPDIFF(YEAR, dateNaissance, CURDATE()) < 19" );
		
		$row = $stmt->fetch ( PDO::FETCH_ASSOC );
		return $row ['effectif'];
	}
	
	/*
	 * Récupère le nombre de femmes d'un type de parcours si
	 * le paramètre est passé, sinon le nombre de femmes au total
	 * @return : un entier
	 */
	private function getEffectifFemmes($parcours = "") {
		if (empty($parcours))
			$stmt = $this->pdo->query ( "SELECT COUNT(*) as effectif FROM INSCRIPTIONS WHERE sexe='F'" );
		else
			$stmt = $this->pdo->query ( "SELECT COUNT(*) as effectif FROM INSCRIPTIONS JOIN PARCOURS ON parcours = idParcours WHERE type='$parcours' AND sexe='F'" );
		
		$row = $stmt->fetch ( PDO::FETCH_ASSOC );
		return $row ['effectif'];
	}
}
?>