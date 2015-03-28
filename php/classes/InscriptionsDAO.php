<?php
// Classe pour l'accès à la table INSCRIPTION
class InscriptionsDAO extends DAO {
	protected $table = "INSCRIPTIONS";
    protected $class = "Inscription";
    
    /* 
     * Méthode permettant d'obtenir les 10 derniers enregistrements d'un utilisateur
     * @return : un tableau d'inscriptions
     */
    public function getLastTen($user) {
        $res = array();
        $stmt = $this->pdo->prepare("SELECT * FROM INSCRIPTIONS WHERE inscriveur=? ORDER BY idInscription DESC LIMIT 10");
        $stmt->execute(array($user));
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row)
        	$res[] = new Inscription($row);
        return $res;
    }
    
    /*
     * Méthode qui teste si une inscription fait référence à un parcours ou à un utilisateur
     * @return : un booléen
     */
    public function checkRef($parcoursOrUtilisateur) {
    	$stmt = $this->pdo->prepare("SELECT * FROM INSCRIPTIONS WHERE parcours=? OR inscriveur=? LIMIT 1");
    	$stmt->execute(array($parcoursOrUtilisateur, $parcoursOrUtilisateur));
    	$res = $stmt->fetchAll(PDO::FETCH_ASSOC);    	
    	if (empty($res))
    		return false;
    	else
    		return true;
    }
}
?>
