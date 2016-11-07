<?php
namespace App\Bs\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;
use App\Utils\U;
use Cake\Event\Event;
use Cake\Network\Response;

/**
 * Comments Controller
 *
 * @property \App\Model\Table\CommentsTable $Comments
 */
class BsCommentsController extends AppController
{
    protected function addFields() {
        $user = $this->Auth->user();
        $dname = U::makeUserDisplayName($user);
        $this->app_nowfields["user_id"] = [
            "type" => "raw",
            "label" => "ユーザ",
            "value" => "<input type='hidden' name='user_id' value='{$user['id']}'></input>{$dname}",
        ];
    }

    protected function indexFields() {
        unset($this->app_nowfields["action"]);
        $this->app_nowfields["created"] = [
            "type" => "datetime",
            "label" => "日時"
        ];
    }

    public function beforeRedirect(Event $event, $url, Response $response) {
        parent::beforeRedirect($event, $url, $response);        // viewの場合はindexにリダイレクト
        if(array_key_exists("action", $url)) {
            if($url["action"] == "view") {
                $response->location("/orgbake/Comments/index");
            }
        }
   }
}
