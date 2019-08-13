<?php

class UserList{

    /*
        getList(string $userName [, string $listName...]): array
        
        Returns selected or all user's lists. Array(requested list(s)).

        If 0 lists given - returns all(watched, planned, favourite, watching).
        Checks Redis(database 1) for each one. Puts missing value from db.
    */
    public static function getList($userName, ...$listName){
        if(count($listName) == 0)$listName = ['watched', 'planned', 'favourite', 'watching'];

        global $redis;
        $redis->select(1);

        foreach ($listName as $key => $list) {
            $result[$list] = $redis->hget($userName, $list);
            if(strlen($result[$list]) > 0) unset($listName[$key]);
        }

        $redis->expire($userName, 900);

        if(count($listName) > 0){
            $db = DB::getConnection();

            $lists = implode(',', $listName);

            $dbresult = $db->preparedQuery("SELECT $lists FROM userlists WHERE userName=?", $userName);
            if($dbresult->rowCount() == 0){error_log("UserList::getList: 0 rows from db on user $userName", 0); return $result;}
            
            $dbresult->setFetchMode(PDO::FETCH_ASSOC);
            $result = array_merge($result, $dbresult->fetch());

            foreach ($result as $key => $value) $redis->hset($userName, $key, $value);
        }

        foreach ($result as &$value) $value = explode(';', $value);

        return $result;
    }
}
