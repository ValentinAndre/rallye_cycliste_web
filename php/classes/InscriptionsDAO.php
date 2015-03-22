<?php
// Classe pour l'accès à la table INSCRIPTION
class InscriptionsDAO extends DAO {
	protected $table = "INSCRIPTIONS";
    protected $class = "Inscription";
    
    // Méthode permettant d'afficher les 10 derniers enregistrements d'un utilisateur
    public function getLastTen($user) {
        $res = array();
        $stmt = $this->pdo->prepare("SELECT * FROM INSCRIPTIONS WHERE inscriveur=? ORDER BY idInscription DESC LIMIT 10");
        $stmt->execute(array($user));
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row)
        	$res[] = new Inscription($row);
        return $res;
    }
}
?>
