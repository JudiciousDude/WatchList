<?php

class Profile{

    /*
        Returns all profile info
    */
    public static function getProfileByName($name){
        $db = Db::getConnection();

        $result = $db->query("SELECT * FROM users WHERE name='{$name}'");
        if($result == false){return null;}

        $result->setFetchMode(PDO::FETCH_ASSOC);
        $profile = $result->fetch();

        return $profile;
    }
}
