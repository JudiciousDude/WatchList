<?php
class Router{

    private $routes;

    public function __construct(){
        $this->routes = include(ROOT.'/src/config/routes.php');
    }

    /*
        Returns request string 
    */
    private function getURL(){
        if(!empty($_SERVER['REQUEST_URI'])){
            return trim($_SERVER['REQUEST_URI'],'/');
        }
    }

    public function run(){

        $url = $this->getURL();
        //redo
        foreach($this->routes as $path => $controller){
            if(preg_match("~$path~", $url)){

                $parts = explode('/', $controller);

                $controllerName = ucfirst(array_shift($parts)).'Controller'; 
                $controllerMethod = array_shift($parts);    
                
                $controllerFile = ROOT.'/src/controllers/'.$controllerName.'.php';

                if(file_exists($controllerFile)){
                    include_once($controllerFile);
                }

                $controllerObj = new $controllerName;
                $result = $controllerObj->$controllerMethod();
                if($result != null) break;
            }
        }
    }

}
