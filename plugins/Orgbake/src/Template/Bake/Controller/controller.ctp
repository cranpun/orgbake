<%
/**
 * Controller bake template file
 *
 * Allows templating of Controllers generated from bake.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.1.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
use Cake\Utility\Inflector;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

$defaultModel = $name;

// Bsクラスを使用するか否かのフラグ
$usebs = Configure::read("usebs");
if(in_array($defaultModel, $usebs)) {
    $extends = "Bs{$defaultModel}Controller";
    $use = "use {$namespace}\\Bs\\Controller{$prefix}\\" . $extends . ";";
} else {
    $extends = "AppController";
    $use = "";
}
%>
<?php
namespace <%= $namespace %>\Controller<%= $prefix %>;

<%= $use %>
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;
use App\Utils\U;

/**
 * <%= $name %> Controller
 *
 * @property \<%= $namespace %>\Model\Table\<%= $defaultModel %>Table $<%= $defaultModel %>
<%
foreach ($components as $component):
    $classInfo = $this->Bake->classInfo($component, 'Controller/Component', 'Component');
%>
 * @property <%= $classInfo['fqn'] %> $<%= $classInfo['name'] %>
<% endforeach; %>
 */
class <%= $name %>Controller extends <%= $extends %>
{
    function initialize() {
        // まずAppControllerのinitilizeをよぶ
        parent::initialize();
        // フィールドデータの出力
<%
// フィールドの配列：翻訳のために、bakeで出力する
$tab = TableRegistry::get($currentModelName);
$schema = $tab->schema();
$columns = $schema->columns();



foreach($columns as $column) :
        if(in_array($column, ["created", "modified"])) {
            // デフォルト表示しないデータ
            continue;
        }
        // idなら文字列で。
        $type = ($column == "id" ? "string" : $schema->columnType($column));
%>
        $this->app_nowfields['<%= $column %>'] = [
            "label" => __('<%= $currentModelName %>-<%= $column %>'),
            "type" => '<%= $type %>',
        ];
<% endforeach; %>

        // アソシエーション関連のデータを抽出
<%
// 外部キーは関連テーブルのnameに置き換え。キーは外部キー、値は小文字アンダーバーつなぎの単数
foreach($tab->associations()->type("BelongsTo") as $bt) :
        // 外部データのため、タイプを文字列に修正
%>
        $this->app_nowfields['<%= $bt->foreignKey() %>']['type'] = "string";
        $this->app_nowassoc['<%= $bt->foreignKey() %>'] = '<%= $bt->property() %>';
        
<% endforeach; %>

        // タイトルの生成：モデル名
        $this->app_nowtitle = __('<%= $currentModelName %>');
    }
<%
echo $this->Bake->arrayProperty('helpers', $helpers, ['indent' => false]);
echo $this->Bake->arrayProperty('components', $components, ['indent' => false]);
foreach($actions as $action) {
    echo $this->element('Controller/' . $action);
}
%>
}
