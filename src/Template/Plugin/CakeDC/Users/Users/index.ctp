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
use App\Utils\U;
$now_role = $app_nowauth->user()["role"];
$now_id =  $app_nowauth->user()["id"];
$now_enableDeactive = array_key_exists("enableDeactive", $this->request->query);
?>
<!-- datatables -->
<script type="text/javascript">
$(function() {
    initDataTables("#indextable");
});
</script>
<div class="users index content">
    <div class="text-right">
            <form id="reload" name="reload">
                <div class="checkbox">
                    <label for="enableDeactive" >
                        <input type="checkbox" name="enableDeactive" id="enableDeactive" 
                            onchange="$('#reload').submit()" 
                            <?= $now_enableDeactive ? " checked " : "" ?>>
                        無効ユーザ表示
                    </label>
                </div>
            </form>
    </div>
    <br/>
    <table id="indextable" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th>ユーザ名</th>
                <th>権限</th>
                <th>メールアドレス</th>
                <th>苗字</th>
                <th>名前</th>
                <th>操作</th>
            </tr>
        </thead>
            <tbody>
    <?php foreach (${$tableAlias} as $user) : ?>
        <?php if($now_role == "user" && $now_id != $user->id) {
            // 権限が一般かつIDが違うなら表示しない
            continue;
        } ?>
        <?php if($user->active != 1 && !$now_enableDeactive) {
            // 無効ユーザはデフォルト表示しない
            continue;
        } ?>
        
        <tr>
            <td><?= h($user->username) ?></td>
            <td><?= U::loadLabelConf("roles", $user->role) ?></td>
            <td><?= h($user->email) ?></td>
            <td><?= h($user->last_name) ?></td>
            <td><?= h($user->first_name) ?></td>
            <td class="actions">
                <?= $this->Html->link(__d('CakeDC/Users', 'View'), ['action' => 'view', $user->id]) ?>
                <?= $this->Html->link(__d('CakeDC/Users', 'Change password'), ['action' => 'changePassword', $user->id]) ?>
                <?= $this->Html->link(__d('CakeDC/Users', 'Edit'), ['action' => 'edit', $user->id]) ?>
            </td>
        </tr>

    <?php endforeach; ?>
    </tbody>
    </table>
</div>
