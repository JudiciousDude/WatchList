<?php

include_once(ROOT.'/src/models/Profile.php');

class ProfileController{

    /*
        Shows user's own profile.
    */
    public function userProfile($username){
        echo "userProfile | profile of $username";
        return true;
    }

}
