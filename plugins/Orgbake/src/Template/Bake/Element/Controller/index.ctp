<%
/**
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
%>

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->app_nowsubtitle = "一覧";

        // indexは基本のフィールド以外に末尾にAction
        $this->app_nowfields["action"] = ["label" => "操作"];

        // 基本処理
        $<%= $pluralName %> = $this-><%= $currentModelName %>->find();
<% $belongsTo = $this->Bake->aliasExtractor($modelObj, 'BelongsTo'); %>
<% if ($belongsTo): %>
        $<%= $pluralName %>->contain([<%= $this->Bake->stringifyList($belongsTo, ['indent' => false]) %>]);
<% endif; %>
        // index専用Queryカスタム用hook
        if(method_exists($this, "indexQuery")) {
            $<%= $pluralName %> = $this->indexQuery($<%= $pluralName %>);
        }

        // 外部キーをラベルに変換。nowfieldではassociationではなく、外部キーで扱うため、外部キーの値に設定。
        foreach($<%= $pluralName %>->toArray() as $row) {
            foreach($this->app_nowassoc as $foreignkey => $tab) {
                if($tab == "user") {
                    // userは特別対応。display_fieldではないため。
                    $row->{$foreignkey} = U::makeUserDisplayName($row->user);
                } else {
                    // display_fieldがあれば、そのデータを設定
                    $tabobj = TableRegistry::get(Inflector::pluralize($tab));
                    if($tabobj->displayField() != "") {
                        $row->{$foreignkey} = $row->{$tab}->{$tabobj->displayField()};
                    }
                }
            }
            $this->app_nowdata[] = $row->toArray();
        }

        // メニューデータの生成
        $this->app_nowmenus = [
            __("<%= $currentModelName %>") . "追加" => [
                "controller" => "<%= $pluralName %>",
                "action" => "add",
            ],
        ];
    }
