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
$Users = ${$tableAlias};
?>

<div class="payments view content">
    <table class="vertical-table table">
        <tr>
            <th>
                ID
            </th>
            <td>
                <?= h($Users->id) ?>
            </td>
        </tr>
        <tr>
            <th>
                アカウント名
            </th>
            <td>
                <?= h($Users->username) ?>
            </td>
        </tr>
        <tr>
            <th>
                メールアドレス
            </th>
            <td>
                <?= h($Users->email) ?>
            </td>
        </tr>
        <tr>
            <th>
                苗字
            </th>
            <td>
                <?= h($Users->last_name) ?>
            </td>
        </tr>
        <tr>
            <th>
                名前
            </th>
            <td>
                <?= h($Users->first_name) ?>
            </td>
        </tr>
        <tr>
            <th>
                権限
            </th>
            <td>
                <?= U::loadLabelConf("roles", $Users->role) ?>
            </td>
        </tr>
        <tr>
            <th>
                状態
            </th>
            <td>
                <?= $Users->active == 1 ? "有効" : "無効" ?>
            </td>
        </tr>
    </table>
</div>
