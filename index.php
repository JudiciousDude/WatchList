<?php

//Settings
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Connecting files
define('ROOT', dirname(__FILE__));
require_once(ROOT.'/src/components/Router.php');
require_once(ROOT.'/src/components/DB.php');

$views = getViews();
function getViews(){
    $vlist = include_once(ROOT.'/src/config/views.php');
    foreach($vlist as $key => &$path){
        $path = ROOT.'/src/views/'.$path;
    }
    return $vlist;
}

//Router
$router = new Router();
$router->run();
