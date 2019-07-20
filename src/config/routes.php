<?php

return array(
    //'path' => 'controllerName/controllerMethod[/params]'
    'login' => 'login/log',
    'profile' => 'profile/user',
    '([a-z,A-Z,0-9,_]+)' => 'profile/showUser/$1',
);
