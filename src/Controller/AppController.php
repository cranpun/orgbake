<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Network\Response;
use Cake\Core\Configure;
use App\Utils\U;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    // View変数。beforeRenderでset。Bsで書き換えることでカスタマイズ可能。
    // // サイドメニュー：配列だと権限チェック。文字列ならそのまま出力。初期値は各アクション。
    protected $app_nowmenus;

    // // DBから読みだしてきた配列。viewならfieldと値の連想配列
    // // index画面ならその連想配列の配列。
    // // add, editならentity。
    // // 初期値は各アクションの中。
    protected $app_nowdata;

    // // 出力するフィールド。
    // // キーをカラム名（小文字アンダーバー）、値にlabel, typeの連想配列。
    // // 初期値はinitialize。
    protected $app_nowfields;

    // // 現在のアソシエーションデータ。キーはこのテーブルの外部キー。
    // // 値は小文字アンダーバーつなぎの単数テーブル（containでひっぱってきたデータへのアクセスに利用）
    // // 初期値はinitialize。
    protected $app_nowassoc;

    // // 追加で表示する内容。適当なカスタム関数内で呼び出し。
    protected $app_topcontent;
    protected $app_btmcontent;

    // // 表示するタイトル。head内とh1
    protected $app_nowtitle;
    
    // // 表示するサブタイトル（アクション）。
    protected $app_nowsubtitle;

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('CakeDC/Users.UsersAuth');
        if($this->Auth->user()) {
            // ログインしていたらchangePasswordに制限をかける。
            // デフォルトOKになるため、他の人のにアクセスすると書き換えられてしまうため。
            $this->Auth->deny("changePassword");
            // 何故かisAuthorizedを呼び出しておかないと、providerが取得できない。
            $this->Auth->isAuthorized();
        }
        $this->Auth->allow('store');

        // view変数初期化
        $this->app_nowfields = [];
        $this->app_nowmenus = [];
        $this->app_nowdata = [];
        $this->app_nowassoc = [];
        $this->app_topcontent = "";
        $this->app_btmcontent = "";
    }

    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return void
     */
    public function beforeRender(Event $event)
    {
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }

        // メニューの設定。controllerの処理の後に実施するため、beforeRenderで。
        $checkedmenus = [];

        // 各種フックの実行
        $action = $this->request->params["action"];
        
        $fnames = [
            "{$action}Fields", // フィールドのカスタム
            "{$action}Menus", // メニューのカスタム
            "{$action}After", // beforeHook。その他のカスタム
        ];
        foreach($fnames as $fname) {
            if(method_exists($this, $fname)) {
                $this->{$fname}();
            }
        }

        // メニューの設定があれば権限チェック
        if(count($this->app_nowmenus) > 0) {
            foreach($this->app_nowmenus as $label => $menu) {
                if(!is_array($menu)) {
                    // 文字列なら設定先で確認しているはずなのでそのまま出力
                    $checkedmenus[$label] = $menu;
                } else {
                    $res = U::canDo($this->Auth, $menu);
                    if($res) {
                        $checkedmenus[$label] = $menu;
                    }
                }
            }
        }

        // view変数のset
        $this->set("app_nowauth", $this->Auth);
        $this->set("app_nowmenus", $checkedmenus);
        $this->set("app_nowfields", $this->app_nowfields);
        $this->set("app_nowdata", $this->app_nowdata);
        $this->set("app_nowassoc", $this->app_nowassoc);
        $this->set("app_topcontent", $this->app_topcontent);
        $this->set("app_btmcontent", $this->app_btmcontent);
        $this->set("app_nowtitle", $this->app_nowtitle);
        $this->set("app_nowsubtitle", $this->app_nowsubtitle);
    }

    public function beforeFilter(Event $event) {
        if($this->request->params["controller"] == "Users") {
            $roles = Configure::read("roles");
            $this->set("roles", $roles);

            // メニューはここで生成
            $id = U::getId($this->request); 
            $this->app_nowmenus = U::defaultMenus("ユーザ", "Users", $this->request->params["action"], $id);
            // Usersはpluginなのでその情報を付与
            foreach($this->app_nowmenus as $key => $menus) {
                $this->app_nowmenus[$key]["plugin"] = "CakeDC/Users";
            }
        }
    }
}
