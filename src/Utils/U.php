<?php

namespace App\Utils;

use Cake\Core\Configure;
use Cake\Routing\Router;
use Cake\Network\Request;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;
use \SplFileObject;
use Cake\Utility\Hash;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\Exception\InvalidPrimaryKeyException;

class U {

    /**
     * 指定された$actionに応じて、デフォルトのメニュー配列を返す
     */
    static public function defaultMenus($label, $controller, $action, $id = null) {
        if($action == "index") {
            return [
                "{$label}追加" => [
                    "controller" => $controller,
                    "action" => "add",
                ],
            ];
        } else if($action == "add") {
            return [
                "{$label}一覧" => [
                    "controller" => $controller,
                    "action" => "index",
                ],
            ];
        } else if($action == "view") {
            return [
                "{$label}一覧" => [
                    "controller" => $controller,
                    "action" => "index",
                ],
                "{$label}編集" => [
                    "controller" => $controller,
                    "action" => "edit",
                    $id,
                ],
            ];
        } else if($action == "edit") {
            return [
                "{$label}一覧" => [
                    "controller" => $controller,
                    "action" => "index",
                ],
                "{$label}詳細" => [
                    "controller" => $controller,
                    "action" => "index",
                    $id,
                ],
                "{$label}削除" => [
                    "controller" => $controller,
                    "action" => "delete",
                    $id,
                ],
            ];
        } else {
            return [];
        }
    }

    /**
     * Excelの日時シリアル値をyyyy-mm-dd hh:mm::ssの文字列に変換
     */
    static public function convExcelSerial2Timestr($excelserial, $format = "Y-m-d H:i:s") {
        return date($format, ($excelserial - 25569) * 60 * 60 * 24);
    }


    /**
     * @param $auth AuthComponentのオブジェクト。$controller->Auth。
     * @param $menu メニューを生成するための配列。cntrollerとactionを連想配列で指定、IDがある場合は末尾に設定。
     */
    static public function canDo($auth, $menu) {
        $az = $auth->authorizationProvider();
        //$url = Router::url($menu);
        $request = new Request([
            //"url" => $url, 
            "params" => $menu,
        ]);
        if($az != null) {
        	$res = $az->authorize($auth->user(), $request);
        } else {
        	// もしresetPasswordならばログインなしでもOK
        	if($menu["action"] == "resetPassword") {
        		return true;
        	} else {
        		// それ以外はログインしてなければダメ
        		return false;
        	}
        }
        return $res;
    }

    /**
     * typeに従って値を出力
     */
    static public function printFormat($value, $type) {
        if(in_array($type, ['integer', 'biginteger', 'decimal'])) {
            // 数字
            return number_format($value);
        } else if(in_array($type, ['float'])) {
            // 数字
            return number_format($value, 2);
        } else if(in_array($type, ['datetime'])) {
            // 時刻
            return $value->i18nFormat("yyyy-MM-dd HH:mm:ss");
        } else if(in_array($type, ['date'])) {
            // 日付
            return $value->i18nFormat("yyyy-MM-dd");
        } else if(in_array($type, ['text'])) {
            return nl2br(h($value));
        } else if(in_array($type, ['raw'])) {
            // リンク等そのまま出力
            return $value;
        } else {
            // 文字列、その他
            return h($value);
        }

    }

    /**
     * $pathのファイルをUtf8に変換して取得
     */
    static public function readCsvFile($path) {
        $content = file_get_contents($path);
        $nowcode = mb_detect_encoding($content, ["JIS", "SJIS-win", "UTF-8"]);
        $e_content = mb_convert_encoding($content, "UTF-8", $nowcode);
        $temp = tmpfile();
        $meta = stream_get_meta_data($temp);
        fwrite($temp, $e_content);
        rewind($temp);

        $file = new SplFileObject($meta['uri']);
        $file->setFlags(SplFileObject::READ_CSV);

        $csv = [];
        foreach($file as $line) {
            $csv[] = $line;
        }
        fclose($temp);
        $file = null;

        return $csv; 
    }

    static public function makeEntityError($ent) {
        return [
            $ent->source(),
            $ent->errors(),
            $ent->invalid(),
        ];
    } 

    static public function makeUserDisplayName($user) {
        if(is_array($user)) {
            return h($user["last_name"] . " " . $user["first_name"]);
        } else {
            return h($user->last_name . " " . $user->first_name);
        }
    }

    static public function getId($request = null) {
        $id = Hash::get($request, "pass.0"); 
        if($id == null) {
            // passの下ではなく、直下にある場合もある
            $id = Hash::get($request, "0");
        }
        return $id;
    }

    static public function loadLabelDB($tabname, $id, $nolabel = "（なし）", $labelclm="name") {
        $tab = TableRegistry::get($tabname);
        try{
            $row = $tab->get($id);
            return h($row->{$labelclm});
        } catch(RecordNotFoundException $e) {
            // 存在しない
            return $nolabel;
        }
    }

    static public function loadLabelConf($conf, $id, $nolabel = "（なし）", $labelkey = null) {
        $confdata = Configure::read($conf);
        if(array_key_exists($id, $confdata)) {
            if($labelkey == null) {
                // null 指定の場合、[$key => "ラベル"]のラベルのみの連想配列
                return $confdata[$id];
            } else {
                // labelkeyに指定がある場合は、labelkeyの値を返す
                return $confdata[$id][$labelkey];
            }   
        } else {
            return "（なし）";
        }
    }

    static public function escapeFilename($filename) {
        $chs = [
            "\\" => "￥",
            "/" => "／",
            ":" => "：",
            "*" => "＊",
            "?" => "？",
            "\"" => "”",
            "<" => "＜",
            ">" => "＞",
            "|" => "｜",
            "'" => "’",
            "&" => "＆",
            "$" => "＄",
            "!" => "！",
            "#" => "＃",
            "%" => "％",
            "(" => "（",
            ")" => "）",
            "=" => "＝",
            "-" => "－",
            " " => "　",
            "^" => "＾",
            "~" => "～",
            "@" => "＠",
            "{" => "｛",
            "[" => "「",
            "+" => "＋",
            ";" => "；",
            "}" => "｝",
            "]" => "」",
            "," => "，",
            "." => "．",
            "_" => "＿", 
        ];
        $ret = $filename;
        foreach($chs as $ch => $r) {
            $ret = str_replace($ch, $r, $ret);
        }
        return $ret;
    }

}
