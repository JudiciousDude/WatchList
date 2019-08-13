<?php

include_once(ROOT.'/src/models/UserList.php');
include_once(ROOT.'/src/models/Profile.php');

class ListController{
    public function userList($username, $list){
        if(!isset($_COOKIE['uh'])){header("Location: \login"); return true;}

        $username = Profile::getNameByHash($_COOKIE['uh']);

        if(strlen($list) == 0)$resultList = UserList::getList($username);
        else $resultList = UserList::getList($username, $list);

        require_once(ROOT.'/src/views/testpage.php');
        return true;
    }
}
