<?php
use App\Utils\U;
?>
<div class="<%= $pluralVar %> view content">
    <table class="vertical-table table">
        <?php foreach($app_nowfields as $field => $fdata) : ?>
        <tr>
            <th><?= $fdata["label"] ?></th>
            <td><?= U::printFormat($app_nowdata[$field], $fdata["type"]); ?></td>
        </tr>
        <?php endforeach; // $app_nowfields ?>
    </table>

</div>
