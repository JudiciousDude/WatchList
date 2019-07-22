<?php

include_once(ROOT.'/src/models/Profile.php');

class ProfileController{

    /*
        Shows user's own profile.
    */
    public function showUserProfile(){
        echo "profile list of {$_COOKIE['user']}";
        return true;
    }


    /*
        Shows other user's profile.
    */
    public function showDifferentUser($id){
        $profile = Profile::getProfileByName($id);
        if($profile == null) {echo "No such user"; return true;} 
        require_once(ROOT.'/src/views/UserProfile.php');
        return true;
    }

}
