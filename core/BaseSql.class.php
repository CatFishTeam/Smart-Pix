<?php
class BaseSql{

    private $db;
    private $table;
    private $columns = [];

    //TODO Save error display (log or return)
    //TODO Problem if prepare statement in empty (case : no album yet or no picture yet ~ selectAllBy)

    public function __construct(){
        try {
            $this->db = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PWD);
        } catch(Exception $e) {
            die("Erreur SQL : ".$e->getMessage());
        }

            //Récupérer le nom de la table dynamiquement
            $this->table = strtolower(get_class($this));

            //Récupérer le nom des colonnesde la table dynamiquement
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
                // var_dump($this->db->errorInfo());
                // var_dump($req);
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

    /*
     * Appeler getAllBy() dans un contrôleur :
     * $users = array();
       $user = new User();
       foreach ($user->getAllBy() as $oneUser) {
           array_push($users, $oneUser);
       }
       $v = new View();
       $v->assign('users', $users);
     * ----------------------------
     * Se servir de l'array $users dans une vue :
     * foreach ($users as $user) {
            if ($user['username'] == "toto") {
                $theUser = $user;
                break;
            }
        }
        echo $theUser['email'];
     *
     */
    public function getAllBy($search = [], $order = null, $returnQuery = false){
        if (empty($search)) {
            $query = $this->db->prepare("SELECT * FROM ".$this->table.($order != null ? " ORDER BY created_at ".$order : ""));
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } else {
            foreach($search as $key => $value){
                $where[] = $key.'=:'.$key;
            }
            $query = $this->db->prepare("SELECT * FROM ".$this->table." WHERE ".implode(" AND ", $where).($order != null ? " ORDER BY created_at ".$order : ""));

            $query->execute($search);

            if($returnQuery){
                return $query;
            }
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    public function deleteOneBy($search = [], $returnQuery = false){
        foreach($search as $key => $value){
            $where[] = $key.'=:'.$key;
        }
        $query = $this->db->prepare("DELETE FROM ".$this->table." WHERE ".implode(" AND ", $where));

        $query->execute($search);

        if($returnQuery){
            return $query;
        }
        return true;
    }

    //Clean for every slug/url
    public function clean($string) {
       $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
       $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

       return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
    }
}
