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
 use App\Utils\U;
%>
<?php
use App\Utils\U;
use Cake\ORM\TableRegistry;

// 権限確認用のデータ
$tab = TableRegistry::get($this->request->params["controller"]);
$primaryfields = $tab->schema()->primaryKey();
$primaryfield = $primaryfields[0]; // 主キーは一つ
$controller = $this->request->params["controller"];

?>

<!-- datatables -->
<script type="text/javascript">
$(function() {
    initDataTables("#indextable");
});
</script>

<div class="<%= $pluralVar %> index content">
    <table id="indextable" cellpadding="0" cellspacing="0" class="hdn">
        <thead>
            <tr>
                <?php foreach($app_nowfields as $fdata) : ?>
                <th><?= $fdata["label"] ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach($app_nowdata as $row) : ?>
            <tr>
                <?php foreach($app_nowfields as $field => $fdata) : ?>
                    <?php if($field != "action") : ?>
                    <td> <?= U::printFormat($row[$field], $fdata["type"]); ?> </td>
                    <?php endif; ?>
                <?php endforeach; ?>
                <?php if(array_key_exists("action", $app_nowfields)) : ?>
                <td class="actions">
                    <?php
                    $menudata = [
                        "controller" => $controller,
                        $row[$primaryfield],
                    ];
                    ?>
                    <?php if(U::canDo($app_nowauth, $menudata + ["action" => "view"])): ?>
                        <?= $this->Html->link(__('View'), ['action' => 'view', $row["id"]]) ?>
                    <?php endif; ?>
                    <?php if(U::canDo($app_nowauth, $menudata + ["action" => "edit"])): ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $row["id"]]) ?>
                    <?php endif; ?>
                    <?php if(U::canDo($app_nowauth, $menudata + ["action" => "delete"])): ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $row["id"]], ['confirm' => "本当に削除しますか？ ID：{$row['id']}"]) ?>
                    <?php endif; ?>
                </td>
                <?php endif; ?>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
