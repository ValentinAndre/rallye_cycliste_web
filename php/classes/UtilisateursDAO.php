<?php
// Classe pour l'accès à la table UTILISATEUR
class UtilisateursDAO extends DAO {
	
	protected $table = "UTILISATEURS";
	protected $class = "Utilisateur";
	
	// Teste si une paire mdp/login est dans la table Utilisateurs
	public function check($login, $password)
	{
		$stmt = $this->pdo->prepare("SELECT * FROM UTILISATEURS WHERE login=? AND mdp=?");
		$stmt->execute(array($login, $password));
		$res = $stmt->fetch(PDO::FETCH_ASSOC);
		if ($res === false)
			return false;
		else
			return true;
	}
}
?>
