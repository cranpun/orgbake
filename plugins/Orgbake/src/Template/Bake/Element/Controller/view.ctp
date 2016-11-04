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
$allAssociations = array_merge(
    $this->Bake->aliasExtractor($modelObj, 'BelongsTo'),
    $this->Bake->aliasExtractor($modelObj, 'BelongsToMany'),
    $this->Bake->aliasExtractor($modelObj, 'HasOne'),
    $this->Bake->aliasExtractor($modelObj, 'HasMany')
);
%>

    /**
     * View method
     *
     * @param string|null $id <%= $singularHumanName %> id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->app_nowsubtitle = "詳細";
        
        $this->app_nowdata = $this-><%= $currentModelName %>->get($id, [
            'contain' => [<%= $this->Bake->stringifyList($allAssociations, ['indent' => false]) %>]
        ])->toArray();

        // 連想配列に変換
        // 外部キーをラベルに変換
        foreach($this->app_nowassoc as $foreignkey => $tab) {
            if($tab == "user") {
                // userは特別対応。display_fieldではないため。
                $this->app_nowdata["user_id"] = U::makeUserDisplayName($this->app_nowdata["user"]);
            } else {
                // display_fieldがあれば、そのデータを設定
                $tabobj = TableRegistry::get(Inflector::pluralize($tab));
                if($tabobj->displayField() != "") {
                    $this->app_nowdata[$foreignkey] = $this->app_nowdata[$tab][$tabobj->displayField()];
                }
            }
        }

        // serialize用に内部変数に変換
        $<%= $singularName %> = $this->app_nowdata;
        $this->set('<%= $singularName %>', $<%= $singularName %>);
        $this->set('_serialize', ['<%= $singularName %>']);

        // メニューデータの生成
        $this->app_nowmenus = [
            __("<%= $currentModelName %>") . "一覧" => [
                "controller" => "<%= $pluralName %>",
                "action" => "index",
            ],
            __("<%= $currentModelName %>") . "追加" => [
                "controller" => "<%= $pluralName %>",
                "action" => "add",
            ],
            __("<%= $currentModelName %>") . "編集" => [
                "controller" => "<%= $pluralName %>",
                "action" => "edit",
                $this->app_nowdata["id"],
            ],
        ];
    }
