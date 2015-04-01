<?php
/* Classe pour l'accès aux données d'une base
 * Hypothèses :
 *    Tous les objets manipulés ont la même structure :
 *       - un tableau associatif 'fields' contenant les champs de la table avec leur nom (comme le résultat
 *         d'un fetch sur la table)
 *       - un constructeur recevant un tel tableau en paramètre
 *       - un getter et un setter pour chaque champ
 *       - une méthode getFieldsNamesWithoutKey retournant la liste des noms des champs sans la clé (pour INSERT)
 *       - un attribut statique keyFieldsNames contenant la liste des noms des champs de la clé (pour INSERT)
 *       - une méthode getKeyFieldsValues retournant la liste des valeurs des champs de la clé (pour
 *         INSERT et UPDATE)
 *    Les champs table et class doivent être redéfinis dans les sous-classes
 * NB : un PreparedStatement ne fonctionne pas avec des noms de champ contenant des caractères UTF-8 !
 */

class DAO {
    const UNKNOWN_ID = -1; // Identifiant non déterminé (pour les clés autoincrémentées)
    protected $pdo; // Objet pdo pour l'accès à la table

    // À redéfinir obligatoirement dans les sous-classes
    protected $table; // Nom de la table dans la base
    protected $class; // Nom de la classe dont on veut produire des instances

    // Liste des noms de champ de la clé et clause WHERE avec ces champs
    protected $keyNames;
    protected $keyWhereClause;

    // Construction de la clause WHERE pour la clé primaire (pour getOne, delete et update)
    protected function buildKeyWhereClause() {
        $clause = " WHERE " . $this->keyNames[0] . "=?";
        for ($i = 1; $i < count($this->keyNames); $i++)
            $clause = $clause . " AND " . $this->keyNames[$i] . "=?";
        return $clause;
    }

    // Le constructeur reçoit l'objet PDO contenant la connexion
    public function __construct(PDO $connector) {
        $this->pdo = $connector;
        // NB : le :: ne fonctionne qu'avec une variable et pour PHP >= 5.3
        $class = $this->class;
        $this->keyNames = $class::$keyFieldsNames;
        $this->keyWhereClause = $this->buildKeyWhereClause();
    } 

    // Requêtes préparées pour getOne, delete, insert, update. On ne les prépare qu'une fois.
    private $stmtGetOne = null;
    private $stmtDelete = null;
    private $stmtInsert = null;
    private $stmtUpdate = null;

    // Récupération d'un objet dont on donne la clé (tableau des valeurs composant la clé ou simplement la 
    // valeur si la clé n'est pas composée)
    // Retourne NULL si l'objet n'est pas dans la base.
    public function getOne($key) {
        if ($this->stmtGetOne == null) {
            // Construction de la requête
            $req = "SELECT * FROM $this->table" . $this->keyWhereClause;
            $this->stmtGetOne = $this->pdo->prepare($req);
        }
        if (is_array($key))
            $this->stmtGetOne->execute($key);
        else
            $this->stmtGetOne->execute(array($key));
        
        if ($row = $this->stmtGetOne->fetch(PDO::FETCH_ASSOC)) 
            return new $this->class($row);
        return NULL;
    }

    // Récupération de tous les objets dans une table (peut être vide)
    // $complementRequete contient une chaîne ajoutée à la requête, par exemple :
    //      ORDER BY champ;
    //      WHERE champ = 'valeur';
    public function getAll($complementRequete = "") {
        $res = array();
        $stmt = $this->pdo->query("SELECT * FROM $this->table $complementRequete");
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row)
            $res[] = new $this->class($row);
        return $res;
    }

    // Insertion de l'objet
    public function insert($obj) {
        if ($this->stmtInsert == null) {
            $this->stmtInsert = $this->newInsertStatement($obj);
        }
        if ($obj->hasAutoIncrementedKey) {
            $res = $this->stmtInsert->execute($obj->getFieldsValuesWithoutKey());
            // Autoincrémentée : un seul champ dans la clé
            $id = $this->keyNames[0];
            $obj->$id = $this->pdo->lastInsertId();
        } else {
            $fields = array_merge($obj->getKeyFieldsValues(), $obj->getFieldsValuesWithoutKey());
            $res = $this->stmtInsert->execute($fields);
        }
        return $res;
    }

    // Mise à jour de l'objet, impossible s'il n'y a pas au moins un champ en plus de la clé
    public function update($obj) {
        if (count($obj->getFieldsNamesWithoutKey()) == 0)
            throw new Exception("Invalid field list in $this->class update (empty)");

        if ($this->stmtUpdate == null) {
            $this->stmtUpdate = $this->newUpdateStatement($obj);
        }
        $fields = array_merge($obj->getFieldsValuesWithoutKey(), $obj->getKeyFieldsValues());
        return $this->stmtUpdate->execute($fields);
    }

    // Effacement de l'objet $obj (DELETE)
    public function delete($obj) {
        if ($this->stmtDelete == null) {
            // Construction de la requête
            $req = "DELETE FROM $this->table" . $this->keyWhereClause;
            $this->stmtDelete = $this->pdo->prepare($req);
        }
        return $this->stmtDelete->execute($obj->getKeyFieldsValues());
    }
    
    public function getColumnNames() {
    	$stmt = $this->pdo->query("SHOW COLUMNS FROM $this->table");
    	return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    // Construction du PreparedStatement pour l'insertion, 2 cas :
    //    - clé autoincrémentée : pas insérée
    //    - sinon on met tous les champs
    private function newInsertStatement($obj) {
        $fieldList = "";
        $valueList = "";
        if (! $obj->hasAutoIncrementedKey) { // on met aussi la clé
            foreach ($this->keyNames as $col) {
                $fieldList = $fieldList . "$col, ";
                $valueList = $valueList . "?, ";
            }
        }
        foreach ($obj->getFieldsNamesWithoutKey() as $col) {
            $fieldList = $fieldList . "$col, ";
            $valueList = $valueList . "?, ";
        }
        // On enlève la dernière virgule dans les listes
        $fieldList = substr($fieldList, 0, -2);
        $valueList = substr($valueList, 0, -2);
        $req = "INSERT INTO $this->table ($fieldList) VALUES ($valueList)";
        return $this->pdo->prepare($req); 
    }

    // Construction du PreparedStatement pour la mise à jour, tous les champs sauf la clé
    private function newUpdateStatement($obj) {
        $fieldList = "";
        foreach ($obj->getFieldsNamesWithoutKey() as $col) {
            $fieldList = $fieldList . "$col = ?, ";
        }
        // On enlève la dernière virgule dans la liste
        $fieldList = substr($fieldList, 0, -2);
        $req = "UPDATE $this->table SET $fieldList" . $this->keyWhereClause;
        return $this->pdo->prepare($req); 
    }
}
?>
