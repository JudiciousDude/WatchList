<?php

class Account{

    /*
        Checks if username and password are valid.
        Returns true if everything ok.
    */
    private static function validateLoginAndPass($userName, $password){
        if((strlen($userName) == 0) && (strlen($password) == 0)) throw new AccountException(0);

        if(strlen($userName) == 0) throw new AccountException(1);
        if(strlen($password) == 0) throw new AccountException(2);

        if((strlen($userName) < 3) && (strlen($password) < 3)) throw new AccountException(3);

        if(strlen($userName) < 3) throw new AccountException(4);
        if(strlen($password) < 3) throw new AccountException(5);

        if((strlen($userName) > 20) && (strlen($password) > 20)) throw new AccountException(6);

        if(strlen($userName) > 20) throw new AccountException(7);
        if(strlen($password) > 20) throw new AccountException(8);

        return true;
    }

    public static function userSignIn($userName, $password){
        self::validateLoginAndPass($userName, $password);

        if(!preg_match("~^([a-z,A-Z,0-9,_]+)$~", $userName)) throw new AccountException(9);

        $db = DB::getConnection();

        $result = $db->preparedQuery("SELECT password.userhash, passwordhash 
                FROM username INNER JOIN watchlist.password WHERE userName=?;",$userName);

        if($result->rowCount() == 0) throw new AccountException(11);

        $result = $result->fetch();
        if(!password_verify($password, $result['passwordhash'])) return null;

        return $result['userhash'];
    }

    /*
        createUser(string $userName, string $password): string

        Throws AccountException.

        Creates new user in database.
        Returns hash of new user.
    */
    public static function createUser($userName, $password){
        self::validateLoginAndPass($userName, $password);

        if(!preg_match("~^([a-z,A-Z,0-9,_]+)$~", $userName)) throw new AccountException(9);

        $db = DB::getConnection();

        $result = $db->preparedQuery("SELECT * FROM username WHERE username=?", $userName);
        if($result->rowCount() != 0) throw new AccountException(10);
        
        $passHash = password_hash($password, PASSWORD_BCRYPT);
        $userHash = password_hash($userName.$passHash, PASSWORD_BCRYPT);

        $result = $db->preparedQuery('INSERT INTO username VALUES (?, ?)', $userName, $userHash);
        $result = $db->query("INSERT INTO password(UserHash, PasswordHash) VALUES ('$userHash', '$passHash')");
        $result = $db->query("INSERT INTO userprofile(UserName) VALUES ('$userName')");
        $result = $db->query("INSERT INTO userlists VALUES ('$userName', 0, 0, 0, 0)");

        return $userHash;
    }

    public static function deleteUser($userName, $password){
    }

    public static function changeUsername($userName, $password){
    }

    public static function changePassword($userName, $password){
    }
}

class AccountException extends Exception{
    private static $codes = [
        0 => 'No username and password',
        1 => 'No username.',
        2 => 'No password.',
        3 => 'Username and password must have a length of at least 3 characters.',
        4 => 'Username must have a length of at least 3 characters.',
        5 => 'Password must have a length of at least 3 characters.',
        6 => 'Username and password must be no longer than 20 characters.',
        7 => 'Username must be no longer than 20 characters.',
        8 => 'Password must be no longer than 20 characters.',
        9 => 'Usernames can contain letters (a-z), numbers (0-9), dashes (-), underscores (_), and periods (.).',
        10 => 'Username is alredy taken.',
        11 => 'No such user.',
    ];
    
    public function __construct(int $code){
        $this->message = self::$codes[$code];
        $this->code = $code;
    }
};
