<?php

include_once(ROOT.'/src/models/Account.php');

class AccountController{

    //IDK how to name this func. Checks if user is logged and if he/she first visiting page.
    private static function idk($page){
        if(isset($_COOKIE['uh'])){
            header('Location: /');
            return true;
        }

        if(!isset($_POST['username']) && !isset($_POST['password'])){
            require_once($page);
            return true;
        }

        return false;
    }

    /*
        Processes user sign in.
    */
    public function login(){        
        $loginPage = ROOT.'/src/views/LoginPage.php';  

        if(self::idk($loginPage)) return true;

        try{
            $hash = Account::userSignIn($_POST['username'], $_POST['password']);
            if(!$hash)return true;
            setcookie('uh', $hash);
            header("Location: /");
        }
        catch(AccountException $e){
            echo $e->getMessage();
        }

        require_once($loginPage);
        return true;
    }
    

    /*
        Processes user creation.
    */
    public function createUser(){
        $createPage = ROOT.'/src/views/LoginPage.php'; 

        if(self::idk($createPage)) return true;

        try{
            $hash = Account::createUser($_POST['username'], $_POST['password']);
            setcookie('uh', $hash);
            header("Location: /");
        }
        catch(AccountException $e){
            echo $e->getMessage();
        }

        require_once($createPage);
        return true;
    }
}
