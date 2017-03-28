<?php
class BaseSql{

    private $db;
    private $table;
    private $columns = [];

    public function __construct(){
            try {
                $this->db = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";port=".DB_PORT,DB_USER,DB_PWD);
            } catch (Exception $e) {
                die("Erreur SQL : ".$e->getMessage());
            }

            //Récupérer le nom de la table dynamiquement
            $this->table = strtolower(get_class($this));

            // //Récupérer le nom des colonnesde la table dynamiquement
            $varObject = get_class_vars($this->table);
            $varParent = get_class_vars(get_parent_class($this));
            $this->columns = array_diff_key($varObject, $varParent);
    }

    public function save(){
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
            // var_dump($data);
            $req = $this->db->prepare("INSERT INTO ".$this->table." (".$sqlCol.") VALUES (".$sqlKey.");");
            $req->execute($data);
        }
        // }else{
        //     foreach($this->columns as $columns => $value){
        //         $data[$columns] = $this->$columns;
        //         $sqlQuery[] = $colums."=:".$columns;
        //     }
        //     $query = $this->db->prepare("UPDATE ".$this->table." SET ".implode(",", $sqlQuery)." WHERE id=:id");
        //     $query->execute($data);
        //     // var_dump($data);
        //     // // $query = $this->prepare("UPDATE ".$this->table." SET ");
        // }
    }


    // Fonction populate : Récupère un tableau (impossibilité d'avoir plusieurs correspondances (cas à gérer) -> retourner l'erreur Objet vide car contrainte d'unicité pas good)
    // $user->populate(["id"=>31]);
    // echo $user->getEmail();

    // Crée getOneBy() aussi


    public function populate($condition = ["id"=>3]){
        //Va chercher dans la table $this->table
        // • Cherche une correspondance avec le modele.
        // •
        strtolower(get_class($this));
        $req = $this->db->prepare("SHOW TABLE");
        $res = $req->execute();
        $req->errorInfo();


        
        foreach ($res as $key => $value) {
            if(strtolower(get_class($this)) == $value){
                echo 'Yolo';
            }
        }


    }
}
