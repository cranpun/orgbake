<?php
namespace App\Bs\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;
use App\Utils\U;
use Cake\Event\Event;
use Cake\Network\Response;
use Cake\Core\Configure;

/**
 * Comments Controller
 *
 * @property \App\Model\Table\CommentsTable $Comments
 */
class BsConfsController extends AppController
{
    protected function editFields() {
        // nameは変更不可
        unset($this->app_nowfields["name"]);
        // ラベルとして表示
        $this->app_nowfields = [
            "namelabel" => [
                "label" => "項目名",
                "type" => "raw",
                "value" => $this->app_nowdata->name, 
            ]
        ] + $this->app_nowfields;

        $this->forDesignTheme();

    }


    private function forDesignTheme() {
        if($this->app_nowdata->id == 1) {
            // デザインテーマなら選択肢に変更
            $themes = Configure::read("themes");
            $this->app_nowfields["value"]["type"] = "raw";

            // selectタグを生成
            $seltag = ["<select name='value' id='value' class='full'>"];
            foreach($themes as $key => $data) {
                if($key == $this->app_nowdata["value"]) {
                    $seld = " selected ";
                } else {
                    $seld = "";
                }
                $seltag[] = "<option value='{$key}' {$seld}>"
                        . "{$key}：{$data['desc']}"
                        . "</option>";
            }
            
            $seltag[] = "</select>";
            // valueが2個でややこしいけど、一つ目はフィールド名、二つ目はrawに対するvalue。
            $this->app_nowfields["value"]["value"] = join("\n", $seltag);
            $this->set("value", $themes);
        }
    }

    protected function indexFields() {
        //unset($this->app_nowfields["action"]);
    }

    public function beforeRedirect(Event $event, $url, Response $response) {
      parent::beforeRedirect($event, $url, $response);        // viewの場合はindexにリダイレクト
      if($url["action"] == "view") {
          $response->location("/orgbake/Confs/index");
      }
   }
}
