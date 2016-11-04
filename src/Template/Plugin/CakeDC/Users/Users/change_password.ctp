<?php 
use Cake\ORM\TableRegistry;

// $tab = TableRegistry::get("Users");
// $userRow = $tab->get($this->request->params["pass"][0]);
// $user = $tab->newEntity();
// if ($this->request->is('post')) {
//     $user = $tab->patchEntity($user, $this->request->data());
// }
?>
<div class="users form">
    <?= $this->Flash->render('auth') ?>
    <?= $this->Form->create($user) ?>
    <fieldset>
        <table class="table vertical-table">
        <?php if ($validatePassword) : ?>
            <tr>
                <th>現在のパスワード</th>
                <td>
                    <?= $this->Form->input('current_password', [
                    'type' => 'password',
                    'required' => true,
                    'label' => false,
                    "class" => "wauto"]);
                    ?>
                </td>
            </tr>
        <?php endif; ?>
            <tr>
                <th>新しいパスワード</th>
                <td><?= $this->Form->input('password', ["label" => false, "class" => "wauto"]); ?></td>
            </tr>
            <tr>
                <th>新しいパスワード（再入力）</th>
                <td>
                    <?= $this->Form->input('password_confirm', ['type' => 'password', 'required' => true, "class" => "wauto", "label" => false]); ?>
                </td>
        </table>
    </fieldset>
    <?= $this->Form->button("更新", ["class" => "btn btn-primary"]); ?>
    <?= $this->Form->end() ?>
</div>