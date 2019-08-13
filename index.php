<?php

/*      Settings        */
ini_set('display_errors', 1);
error_reporting(E_ALL);


/*      Connecting files        */
define('ROOT', dirname(__FILE__));
require_once(ROOT.'/src/components/Router.php');
require_once(ROOT.'/src/components/DB.php');

/*      Redis       */
$redis = new Redis();
$redis->connect("127.0.0.1", 6379);


/*      Router      */
$router = new Router();
$router->run();
