<?php
return [
    //'Users.table' => 'Users',
    'Users.Tos' => [
        'require' => false
    ],
    'Users.Registration' => [
        'active' => false
    ],
    'Users.Profile' => [
        //Allow view other users profiles
        'viewOthers' => true,
        'route' => ['plugin' => 'CakeDC/Users', 'controller' => 'Users', 'action' => 'index'],
    ],
];
