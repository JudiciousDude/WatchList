<?php

class LoginController{
    public function log(){
        setcookie('user','judicious_dude');
        echo 'login';
        return true;
    }
}
