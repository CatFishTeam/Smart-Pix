<?php
class Route{

    private $path;
    private $callable;
    private $matches = [];
    private $params = [];

    public function __construct($path, $callable){
        $this->path = trim($path,'/');
        $this->callable = $callable;
    }

    public function with($param, $regex){
        $this->params[$param] = $regex;
        return $this;
    }

    public function match($url){
        $url = trim($url, '/');
        $path = preg_replace_callback('#:([\w]+)#', [$this, 'paramMatch'], $this->path);

        $regex = "#^$path$#i";

        if(!preg_match($regex, $url, $matches)){
            return false;
        }
        array_shift($matches);
        $this->matches = $matches;
        return true;
    }

    private function paramMatch($match){
        if(isset($this->params[$match[1]])){
            return '('. $this->params[$match[1]] . ')';
        }
        return '([^/]+)';
    }

    public function call(){
        //TODO CHECK IF CONTROLLER EXIST CHECK IF METHOD EXIST
        if(is_string($this->callable)){
            $params = explode('@', $this->callable);
            include "controllers".DS.$params[0]."Controller.class.php";
            $controller = $params[0]."Controller";
            $controller = new $controller();

            return call_user_func_array([$controller, $params[1]], $this->matches);

            return $controller->$params[1]();
        } else {
            return call_user_func_array($this->callable, $this->matches);
        }
    }

    public function getUrl($params){
        $path = $this->path;
        foreach($params as $k => $v){
            $path = str_replace(":$k", $v, $path);
        }
        return $path;
    }
}
