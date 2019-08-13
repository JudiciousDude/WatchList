<?php

return array(
/*  'path' => 'controllerName/controllerMethod[/params]'    */
    'login' => 'account/login',
    'create' => 'account/createUser',
    '6([a-z,A-Z,0-9,_]+)/profile$' => 'profile/userProfile/$1',
    '^([a-z,A-Z,0-9,_]+)(/(watched|planned|favourite|watching))?$' => 'list/userList/$1/$2',
    '^$' => 'main/mainPage',
);
