<?php

//Settings
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Connecting files
define('ROOT', dirname(__FILE__));
require_once(ROOT.'/src/components/Router.php');
require_once(ROOT.'/src/components/Db.php');

//Router
$router = new Router();
$router->run();
