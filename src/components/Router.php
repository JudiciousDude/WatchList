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
        
        foreach($this->routes as $rule => $path){
            if(preg_match("~$rule~", $url)){

                $internalRoute = preg_replace("~$rule~", $path, $url);
                $parts = explode('/', $internalRoute);

                $controllerName = ucfirst(array_shift($parts)).'Controller'; 
                $controllerMethod = array_shift($parts);    
                
                $controllerFile = ROOT.'/src/controllers/'.$controllerName.'.php';

                if(file_exists($controllerFile)) include_once($controllerFile);

                $controllerObj = new $controllerName;
                $result = call_user_func_array(array($controllerObj, $controllerMethod), $parts);
                if($result != null) break;
            }
        }
    }

}
