<?php

class Profile{

    /*
        Searches for user in db.
        Returns both(userHash and passwordHash) users hashes if found, else false.
    */
    public static function getUserHash($userName){
        $db = Db::getConnection();

        $result = $db->preparedQuery("SELECT password.UserHash, PasswordHash 
                FROM username INNER JOIN watchlist.password WHERE UserName=?;",$userName);
        if($result == false){return false;}

        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result = $result->fetch();

        return $result;
    }

    /*
        Returns users hash info.
    */
    public static function getNameByHash($userHash){
        $db = Db::getConnection();

        $result = $db->preparedQuery("SELECT UserName FROM username WHERE UserHash=?", $userHash);
        if($result == false){return null;}

        return $result['UserHash'];
    }

    /*
        Creates new user in database.
        Returns hash of new user or false if user exists.
    */
    public static function createUser($userName, $password){
        $db = DB::getConnection();

        $passHash = password_hash($password, PASSWORD_BCRYPT);
        $userHash = hash('md5', $userName);

        //should be error logging here and transaction
        $result = $db->preparedQuery('INSERT INTO username VALUES (?, ?)', $userName, $userHash);
        if(!$result)return false;
        $result = $db->query("INSERT INTO password(UserHash, PasswordHash) VALUES ('$userHash', '$passHash')");
        if(!$result)return false;
        $result = $db->query("INSERT INTO userprofile(UserName) VALUES ('$userName')");
        if(!$result)return false;
        $result = $db->query("INSERT INTO userlists(UserName) VALUES ('$userName')");
        if(!$result)return false;

        return $userHash;
    }
}
