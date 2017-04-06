<?php
class Routing{

    public $uri;
    public $uriExploded;

    private $controller;
    private $controllerName;
    private $action;
    private $actionName;
    private $params;

    public function __construct(){
        $this->setUri($_SERVER["REQUEST_URI"]);
        $this->setController();
        $this->setAction();
        $this->setParams();
        $this->runRoute();
    }

    public function setUri($uri){
        $uri = preg_replace("/".PATH_RELATIVE_PATTERN."/i", "", $uri, 1);
        $this->uri = trim($uri,'/');
        $this->uriExploded = explode("/", $this->uri);
    }

    public function setController(){
        $this->controller = (empty($this->uriExploded[0])) ? "Index" : ucfirst($this->uriExploded[0]);
        $this->controllerName = $this->controller."Controller";
        unset($this->uriExploded[0]);
    }

    public function setAction(){
        $this->action = (empty($this->uriExploded[1])) ? "index" : $this->uriExploded[1];
        $this->actionName = $this->action."Action";
        unset($this->uriExploded[1]);
    }

    //Merge les variables Post avec les paramètres
    function setParams(){
        $this->params = array_merge(array_values($this->uriExploded), $_POST);
    }

    public function checkRoute(){
            Helpers::createLogExist();
            $pathController = "controllers".DS.$this->controllerName.".class.php";
            //Est ce que le fichier controller existe
            if( !file_exists($pathController) ){
                Helpers::log("Le controller ".$this->controllerName." n'existe pas");
                return false;
            }
            include $pathController;

            //Est ce que l'instanciation est possible
            if( !class_exists($this->controllerName) ){
                Helpers::log("L'instanciation de  ".$this->controllerName." n'est pas possible");
                return false;
            }
            //Est ce que la méthode existe à travers l'objet
            if( !method_exists($this->controllerName, $this->actionName) ){
                Helpers::log("La méthode ".$this->actionName." n'éxiste pas dans ".$this->controllerName);
                return false;
            }

            return true;
    }


    public function runRoute(){
        if($this->checkRoute()){
            $controller = new $this->controllerName;
            $controller->{$this->actionName}($this->params);
        }else{
            $this->page404();
        }
    }

    public function page404(){
        die("Page 404");
    }
}
