<?php

class DB{

    private $dbConnection = false;

    private function __construct($dbConn){
        $this->dbConnection = $dbConn;
    }
    

    public static function getConnection(){
        $config = include(ROOT.'/src/config/dbConfig.php');

        $path = "mysql:host={$config['host']};dbname={$config['dbname']}";
        $db = new PDO($path, $config['user'], $config['password']);

        return new DB($db);
    }


    /*
        Prepares and executes query.
        Returns result of query execute.
    */
    public function preparedQuery($query, ...$args){
        $result = $this->dbConnection->prepare($query);
        $result->execute($args);        
        return $result;
    }


    /*
        Redefines PDO->query().
    */
    public function query($string){
        return $this->dbConnection->query($string);
    }
}