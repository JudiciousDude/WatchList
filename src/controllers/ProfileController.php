<?php

include_once(ROOT.'/src/models/Profile.php');

class ProfileController{

    public function user(){
        echo "profile list of watched {$_COOKIE['user']}";
        return true;
    }

    public function showUser($id){
        $profile = Profile::getProfileByName($id);
        if($profile == null) {echo "No such user"; return true;} 
        require_once(ROOT.'/src/views/UserProfile.php');
        return true;
    }
}
