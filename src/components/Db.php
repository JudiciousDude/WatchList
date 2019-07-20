<?php

class Db{

    public static function getConnection(){
        $config = include(ROOT.'/src/config/dbConfig.php');

        $path = "mysql:host={$config['host']};dbname={$config['dbname']}";
        $db = new PDO($path, $config['user'], $config['password']);

        return $db;
    }
}