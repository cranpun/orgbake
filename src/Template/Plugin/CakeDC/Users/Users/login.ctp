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

use Cake\Core\Configure;

?>
<div class="users form">
    <?= $this->Flash->render('auth') ?>
    <?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __d('CakeDC/Users', 'ログイン') ?></legend>
        <table class="vertical-table table">
            <tr>
                <th>ユーザ</th>
                <td>
                    <?= $this->Form->input('username', ['required' => true, "label" => false]) ?>
                </td>
            <tr>
            <tr>
                <th>パスワード</th>
                <td>
                    <?= $this->Form->input('password', ['required' => true, "label" => false]) ?>
                </td>
            </tr>
        </table>
    </fieldset>
    <div class="row">
        <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
            <?= $this->Form->button("ログイン", ["class" => "btn btn-primary full"]); ?>
        </div>
        <div class="hidden-xs col-sm-4 col-md-6 col-lg-8"></div>
        <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
            <?php
            $registrationActive = Configure::read('Users.Registration.active');
            if ($registrationActive) {
                echo $this->Html->link(__d('CakeDC/Users', 'Register'), ['action' => 'register']);
            }
            if (Configure::read('Users.Email.required')) {
                if ($registrationActive) {
                    echo ' | ';
                }
                echo $this->Html->link('パスワードリセット', ['action' => 'requestResetPassword'], ["class" => "btn btn-primary full"]);
            }
            ?>
        </div>
    </div> <!-- .row -->
    <div class="sr-only">
    <?php
    if (Configure::read('Users.reCaptcha.login')) {
        echo $this->User->addReCaptcha();
    }
    if (Configure::read('Users.RememberMe.active')) {
        echo $this->Form->input(Configure::read('Users.Key.Data.rememberMe'), [
            'type' => 'checkbox',
            'label' => __d('CakeDC/Users', 'Remember me'),
            'checked' => 'checked'
        ]);
    }
    ?>
    </div>
    <?= implode(' ', $this->User->socialLoginList()); ?>
    <?= $this->Form->end() ?>
</div>
