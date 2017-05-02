<?php
class BaseSql{

    private $db;
    private $table;
    private $columns = [];

    public function __construct(){
        try {
            $this->db = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PWD);
        } catch(Exception $e) {
            die("Erreur SQL : ".$e->getMessage());
        }

            //Récupérer le nom de la table dynamiquement
            $this->table = strtolower(get_class($this));

            // //Récupérer le nom des colonnesde la table dynamiquement
            $varObject = get_class_vars($this->table);
            $varParent = get_class_vars(get_parent_class($this));
            $this->columns = array_diff_key($varObject, $varParent);
    }

    public function save() {
        if ($this->id == -1) {

            unset($this->columns['id']);
            $sqlCol = null;
            $sqlKey = null;
            foreach ($this->columns as $columns => $value) {
                $data[$columns] = $this->$columns;
                $sqlCol .= ",".$columns;
                $sqlKey .= ", :".$columns;
            }
            $sqlCol = trim($sqlCol, ",");
            $sqlKey = trim($sqlKey, ",");
            try {
                $req = $this->db->prepare("INSERT INTO ".$this->table." (".$sqlCol.") VALUES (".$sqlKey.");");
                $req->execute($data);
                echo "<div class='flash flash-success'>Inscription terminée !</div>";
            } catch (Exception $e) {
                die($e->getMessage());
            }
        } else {

            $sqlQuery = null;
            foreach ($this->columns as $columns => $value) {
                $data[$columns] = $this->$columns;
                $sqlQuery .= $columns . " = :" . $columns . ", ";
            }
            $sqlQuery = trim($sqlQuery, ", ");
            $req = $this->db->prepare("UPDATE ".$this->table." SET ".$sqlQuery." WHERE id = :id;");
            $req->execute($data);
            echo "update";

        }
    }


    public function populate( $search = [] ){
        //Requete SQL
        //Vérification
        //Alimentation de l'Objet
        $query = $this->getOneBy($search, true);
        //PDO::FETCH_PROPS_LATE : appeler le constructor apres l'alimentation de l'objet
        $query->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, $this->table);
        $object = $query->fetch();
        return $object;

    }

    public function getOneBy($search = [], $returnQuery = false){
        foreach($search as $key => $value){
            $where[] = $key.'=:'.$key;
        }
        $query = $this->db->prepare("SELECT * FROM ".$this->table." WHERE ".implode(" AND ", $where));

        $query->execute($search);

        if($returnQuery){
            return $query;
        }
        return $query->fetch(PDO::FETCH_ASSOC);
    }
}
