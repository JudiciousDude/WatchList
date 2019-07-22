<?php

class MainController{

    public function mainPage(){
        require_once(ROOT.'/src/views/MainPage.php');
        return true;
    }
}
