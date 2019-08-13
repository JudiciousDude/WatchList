<?php

class DB extends PDO{

    /*
        Returns DB object = PDO(configured) + function preparedQuery().
    */
    public static function getConnection(){
        $config = include(ROOT.'/src/config/dbConfig.php');

        $path = "mysql:host={$config['host']};dbname={$config['dbname']}";
        $db = new DB($path, $config['user'], $config['password']);

        return $db;
    }


    /*
        Prepares and executes query.
        Returns result of the query execute.
    */
    public function preparedQuery($query, ...$args){
        $result = $this->prepare($query);
        $result->execute($args);        
        return $result;
    }
}