<?php

return array(
    //'path' => 'controllerName/controllerMethod[/params]'
    'profile' => 'profile/showUserProfile',
    'login' => 'account/login',
    'create' => 'account/createUser',
    '([a-z,A-Z,0-9,_]+)' => 'profile/showDifferentUser/$1',
    '' => 'main/mainPage',
);
