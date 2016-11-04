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
?>
<div class="payments form content">
    <?= $this->Form->create(${$tableAlias}); ?>
    <fieldset>
        <table class="vertical-table table">
            <tr>
                <th>アカウント名</th>
                <td>
                    <?= $this->Form->input("username", 
                            ["label" => false]
                    ) ?>
                </td>
            </tr>
            <tr>
                <th>パスワード</th>
                <td>
                    <?= $this->Form->input("password", 
                            ["label" => false]
                    ) ?>
                </td>
            </tr>
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
        </table>
    </fieldset>
    <?= $this->Form->button("追加", ["class" => "btn btn-primary"]) ?>
    <?= $this->Form->end() ?>
</div>
