<?php
/**
 * Copyright 2010 - 2015, Cake Development Corporation (http://cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2010 - 2015, Cake Development Corporation (http://cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/*
 * IMPORTANT:
 * This is an example configuration file. Copy this file into your config directory and edit to
 * setup your app permissions.
 *
 * This is a quick roles-permissions implementation
 * Rules are evaluated top-down, first matching rule will apply
 * Each line define
 *      [
 *          'role' => 'role' | ['roles'] | '*'
 *          'prefix' => 'Prefix' | , (default = null)
 *          'plugin' => 'Plugin' | , (default = null)
 *          'controller' => 'Controller' | ['Controllers'] | '*',
 *          'action' => 'action' | ['actions'] | '*',
 *          'allowed' => true | false | callback (default = true)
 *      ]
 * You could use '*' to match anything
 * 'allowed' will be considered true if not defined. It allows a callable to manage complex
 * permissions, like this
 * 'allowed' => function (array $user, $role, Request $request) {}
 *
 * Example, using allowed callable to define permissions only for the owner of the Posts to edit/delete
 *
 * (remember to add the 'uses' at the top of the permissions.php file for Hash, TableRegistry and Request
   [
        'role' => ['user'],
        'controller' => ['Posts'],
        'action' => ['edit', 'delete'],
        'allowed' => function(array $user, $role, Request $request) {
            $postId = Hash::get($request->params, 'pass.0');
            $post = TableRegistry::get('Posts')->get($postId);
            $userId = Hash::get($user, 'id');
            if (!empty($post->user_id) && !empty($userId)) {
                return $post->user_id === $userId;
            }
            return false;
        }
    ],
 */

use Cake\Network\Request;
use Cake\ORM\TableRegistry;
use App\Utils\U;

return [
    // ********************************
    // 権限は上のほうが優先で適用される。アスタリスク指定は下にすると便利。
    // ********************************
    'Users.SimpleRbac.permissions' => [
        // エラーページは誰でもOK。
        [
            "role" => "*",
            "controller" => "Pages",
            "action" => "err",
            "allowed" => true,
        ],    
        // **** Users **** //
        [
            // userは自分だけ。
            'role' => ['user'],
            'plugin' => 'CakeDC/Users',
            'controller' => 'Users',
            'action' => ["edit", "view", "changePassword", "login", "logout"],
            'allowed' => function(array $user, $role, Request $request) {
                if($request["controller"] != "Users") {
                    // 関係ないコントローラならチェックしない
                    return true;
                }
                if(!array_key_exists("pass", $request)) {
                    // IDがなければ確認不要
                    return true;
                }
                if(count($request["pass"]) <= 0) {
                    // IDがなければ確認不要
                    return true;
                }
                $accessuserid = $request["pass"][0];
                // UserIdが同じならOK
                $nowuserid = $user["id"];
                $ret = $nowuserid == $accessuserid;
                return $ret;
            },
        ],
        [
            // 一覧は自分だけ表示するロジックを組み込む
            'role' => ['user'],
            'plugin' => 'CakeDC/Users',
            'controller' => 'Users',
            'action' => ["index"],
            'allowed' => true,
        ],
        [
            // これらのアクションは不可。
            'role' => ['user'],
            'plugin' => 'CakeDC/Users',
            'controller' => 'Users',
            'action' => ["index", "add", "delete"],
            'allowed' => false,
        ],
        [
            // adminはなんでもOKに。
            'role' => ['admin'],
            'plugin' => 'CakeDC/Users',
            'controller' => 'Users',
            'action' => "*",
            'allowed' => true,
        ],
        [
            // ユーザは基本OK。ログイン等あるので全体を許可する。
            'role' => ["user", "admin"],
            'plugin' => 'CakeDC/Users',
            'controller' => 'Users',
            'action' => "*",
            'allowed' => true,
        ],
        [
            // ログインしてない人向けにloginとlogoutは許可
            'role' => "*",
            'plugin' => 'CakeDC/Users',
            'controller' => 'Users',
            'action' => ["login", "logout", "changePassword"],
            'allowed' => true,
        ],
        [
            'role' => "*",
            'controller' => 'Comments',
            'action' => ["add", "index"],
            'allowed' => true,
        ],
        [
            'role' => "*",
            'controller' => 'Comments',
            'action' => ["edit", "view", "delete"],
            'allowed' => false,
        ],
        [
            'role' => ["admin"],
            'controller' => 'Confs',
            'action' => ["edit", "index"],
            'allowed' => true,
        ],

        // 基本は全て不許可
        [
            'role' => "*",
            'controller' => '*',
            'action' => "*",
            'allowed' => false,
        ],


        ]
];
