<?php

include_once(ROOT.'/src/models/Profile.php');

class AccountController{
    
    /*
        Checks if user is logged and redirects it if so.
        Returns True if user is redirected.
    */
    private function denyIfLogged(){
        if(isset($_COOKIE['uh'])){
            header('Location: /');
            return true;
        }
        return false;
    }

    /*
        Shows distination page with reason.
    */
    private static function deny($destination, $reason = ''){ 
        require_once($destination);
        echo $reason;
    }

    
    private static function validateLoginAndPass($denyDestination){
        //Checking if login and password is filled
        if(!isset($_POST['login'], $_POST['password'])){
            self::deny($denyDestination); 
            return false;
        }

        //Checking login and password length
        if(strlen($_POST['login']) < 3){
            self::deny($denyDestination, 'Login must be at least 3 characters.');

            if(strlen($_POST['password']) < 3){
                self::deny($denyDestination, 'Password is too short.');
                return false;
            }

            return false;
        }
        return true;
    }


    /*
        Shows login page view and processes user login.
    */
    public function login(){
        if(self::denyIfLogged())return true;

        global $views;

        $loginPage = $views['LoginPage'];
        if(!self::validateLoginAndPass($loginPage))return true;

        $login = $_POST['login'];
        $password = $_POST['password'];        

        //Searching this user and checking password
        $userHash = Profile::getUserHash($login);
        if(!$userHash){deny($loginPage, 'No such user.'); return true;}
        if(password_verify($password, $userHash['PasswordHash'])){deny($loginPage, 'Wrong password.'); return true;}

        //Success. User is redirected to main page
        setcookie('uh', $userHash['UserHash']);
        header("Location: /");
        return true;
    }
    

    /*
        Shows creating page view and creates new user.
    */
    public function createUser(){
        if(self::denyIfLogged())return true;
        
        global $views;

        $createPage = $views['LoginPage'];
        if(!self::validateLoginAndPass($createPage))return true;

        $login = $_POST['login'];
        $password = $_POST['password'];        

        $hash = Profile::createUser($login, $password);
        setcookie('uh', $hash);
        header("Location: /");
        return true;
    }
}
