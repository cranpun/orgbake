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
$compact = [];
%>

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->app_nowsubtitle = "追加";

        // 基本処理
        // // まず空のデータを用意。
        $this->app_nowdata = $this-><%= $currentModelName %>->newEntity();
        if ($this->request->is(['patch', 'post', 'put'])) {
            $conn = $this-><%= $currentModelName %>->connection();
            $ret = $conn->transactional(function($nowconn) {
                $this->app_nowdata = $this-><%= $currentModelName %>->patchEntity($this->app_nowdata, $this->request->data);
                // connectionオブジェクトからではなく、Tableオブジェクトで保存しているが、
                // connection自体がTableから作っているので問題なくロールバックできる。
                $ret = $this-><%= $currentModelName %>->save($this->app_nowdata);

                // 追加の保存処理：falseを返せばロールバック
                if(method_exists($this, "addSave")) {
                    $ret = $this->addSave($nowconn, $ret);
                }

                return $ret;
            });
 
            // 保存結果によってアクションを分岐
            if ($ret) {
                $this->Flash->success(__('The <%= strtolower($singularHumanName) %> has been saved.'));
                return $this->redirect(['action' => 'view', $this->app_nowdata->id]);
            } else {
                $this->Flash->error(__('The <%= strtolower($singularHumanName) %> could not be saved. Please, try again.'));
            }
        }
        
        // 初回またはエラー→同じ画面での処理
<%
        $associations = array_merge(
            $this->Bake->aliasExtractor($modelObj, 'BelongsTo'),
            $this->Bake->aliasExtractor($modelObj, 'BelongsToMany')
        );
        foreach ($associations as $assoc):
            $association = $modelObj->association($assoc);
            $otherName = $association->target()->alias();
            $otherPlural = $this->_variableName($otherName);
%>
        $<%= $otherPlural %> = $this-><%= $currentModelName %>-><%= $otherName %>->find('list', ['limit' => 200]);
<%
            $compact[] = "'$otherPlural'";
        endforeach;
%>
        // compact用に内部変数に切り替え
        $<%= $singularName %> = $this->app_nowdata;
        $this->set(compact(<%= join(', ', $compact) %>));
        $this->set('_serialize', ['<%=$singularName%>']);

        // メニューデータの生成
        $this->app_nowmenus = [
            __("<%= $currentModelName %>") . "一覧" => [
                "controller" => "<%= $pluralName %>",
                "action" => "index",
            ]
        ];
    }
