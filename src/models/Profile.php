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
        Get username by given hash.
        
        Requests Redis for its value. If not set - gets it from database and sets in Redis with expire time = 15 mins.
        Returns null if there no such user in db.
    */
    public static function getNameByHash($userHash){
        global $redis;
        $redis->select(0);
        $username = $redis->get($userHash);
        if(strlen($username) >= 3) return $username;

        $db = Db::getConnection();
        $result = $db->query("SELECT UserName FROM username WHERE UserHash='$userHash'");        
        if($result->rowCount() == 0) return null;

        $username = $result->fetch()['UserName'];

        $redis->set($userHash, $username, 900);

        return $username;
    }
}
