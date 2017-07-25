<?php
class Helpers{
        private $log;
        //Vérification en amont de l'existance d'un fichier et dossier de log.
        public static function createLogExist(){
            if(file_exists("storage/logs/")){
                if(file_exists("storage/logs/last.log")){
                    if(is_writable("storage/logs/last.log")){
                        return true;
                    }
                } else {
                    file_put_contents("storage/logs/last.log");
                    return true;
                }
            } else { return false; }
        }
        //Ecrire les érreurs de routing dans un fichier de log à travers cette fonction là avec le contenu de $msg avec la date et l'heure avant.
        public static function log($msg){
            $log =  date('l jS \of F Y h:i:s A') . " ===> " . $msg . "\n\n";
            file_put_contents("storage/logs/last.log",$log, FILE_APPEND | LOCK_EX);
        }

        //Coder la fonction mais ne l'appellez pas, on passera par un controllerName
        //Limite de taille : 5mo   (On l'archive).
        public static function purgeLog(){
            if(filesize("storage/logs/last.log") > 5242880){
                $newname = date('d_m_y')."_".uniqid().".log";
                rename("storage/logs/last.log","storage/logs/$newname");
            }
        }

}
