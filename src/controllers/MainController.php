<?php

include_once(ROOT.'/src/models/Profile.php');

class MainController{


    public function mainPage(){
        global $redis;
        $username = $redis->hget($_COOKIE['uh'], 'username');
        if(!isset($username))$username = Profile::getNameByHash($_COOKIE['uh']);
        require_once(ROOT.'/src/views/MainPage.php');
        return true;
    }
}
