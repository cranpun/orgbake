<div class="users form">
    <?= $this->Flash->render('auth') ?>
    <?= $this->Form->create('User') ?>
    <fieldset>
        <legend>登録したメールアドレスをご入力ください</legend>
        
        <table class="vertical-table table">
            <tr>
                <th>メールアドレス</th>
                <td>
                    <?= $this->Form->input('reference', ["label" => false]) ?>
                </td>
        </table>
    </fieldset>
    </table>
    <div class="row">
        <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
            <?= $this->Form->button("送信", ["class" => "btn btn-primary full"]); ?>
        </div>
    </div>
    <?= $this->Form->end() ?>
</div>
