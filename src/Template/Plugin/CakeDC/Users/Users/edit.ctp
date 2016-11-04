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

$Users = ${$tableAlias};
?>

<div class="payments form content">
    <?= $this->Form->create($Users); ?>
    <fieldset>
        <table class="vertical-table table">
            <?php if($app_nowauth->user()["role"] != "user"): ?>
            <tr>
                <th>アカウント名</th>
                <td>
                    <?= $this->Form->input("username", 
                            ["label" => false]
                    ) ?>
                </td>
            </tr>
            <?php endif; ?>
            <tr>
                <th>メールアドレス</th>
                <td>
                    <?= $this->Form->input("email", 
                            ["label" => false]
                    ) ?>
                </td>
            </tr>
            <tr>
                <th>苗字</th>
                <td>
                    <?= $this->Form->input("last_name", 
                            ["label" => false]
                    ) ?>
                </td>
            </tr>
            <tr>
                <th>名前</th>
                <td>
                    <?= $this->Form->input("first_name", 
                            ["label" => false]
                    ) ?>
                </td>
            </tr>

            <?php if($app_nowauth->user()["role"] != "user"): ?>
            <tr>
                <th>権限</th>
                <td><?= $this->Form->input("role", ["label" => false]) ?></td>
            </tr>
            <?php endif; ?>
            <?php if($app_nowauth->user()["role"] != "user"): ?>
            <tr>
                <th>状態</th>
                <td>
                    <?= $this->Form->input("active", 
                            ["label" => "（ユーザを無効化するならチェックを外して下さい）",
                             "class" => "wauto",
                            ]
                    ) ?>
                </td>
            </tr>
            <?php endif; ?>
        </table>
    </fieldset>
    <?= $this->Form->button("保存", ["class" => "btn btn-primary"]) ?>
    <?= $this->Form->end() ?>
</div>
