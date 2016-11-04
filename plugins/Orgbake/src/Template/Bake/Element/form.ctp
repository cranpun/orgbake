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
%>

<div class="<%= $pluralVar %> form content">
    <?= $this->Form->create($app_nowdata, ["id" => "nowform"]) ?>
    <fieldset>
        <table class="vertical-table table">
        <?php foreach ($app_nowfields as $field => $data): ?>
            <?php
            if ($field == "id") {
                // 主キーは編集しない。
                continue;
            }
            ?>
            <tr>
                <th><?= $data["label"] ?></th>
                <td>
                <?php
                if($data["type"] == "datetime") {
                    $input = $this->Form->input($field, [
                        "type" => "text",
                        "label" => false,
                        "class" => "form-control"
                    ]);
                    echo <<< EOM
                    <div class="form-group">
                        <div class='input-group datetime' id='ig_{$field}'>
                            {$input}
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-time"></span>
                            </span>
                        </div>
                    </div>
                    <script type="text/javascript">
                    $(function() { initDateTimePicker("#ig_{$field}"); });
                    </script>
EOM;
                } else if($data["type"] == "date") {
                    $input = $this->Form->input($field, [
                        "type" => "text",
                        "label" => false,
                        "class" => "form-control"
                    ]);
                    echo <<< EOM
                    <div class="form-group">
                        <div class='input-group date' id='ig_{$field}'>
                            {$input}
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                    <script type="text/javascript">
                    $(function() { initDatePicker("#ig_{$field}"); });
                    </script>
EOM;
                } else if ($data["type"] == "raw") {
                    // rawの場合は必ずカスタム、valueも一緒に積むのでそれを出力
                    echo $data["value"];
                } else {
                    // 通常はそのまま渡せばよい。
                    echo $this->Form->input($field, ["label" => false]);
                } 
                ?>
                </td>
            </tr>
        <?php endforeach; // $app_nowfields  ?>
        </table> <!-- .vtable -->
    </fieldset>
    <div>
    <?= $this->Form->button("保存", ["class" => "btn btn-primary btn-submit"]) ?>
    </div>
    <?= $this->Form->end() ?>
</div>
