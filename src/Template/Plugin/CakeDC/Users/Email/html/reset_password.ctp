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

$activationUrl = [
    '_full' => true,
    'plugin' => 'CakeDC/Users',
    'controller' => 'Users',
    'action' => 'resetPassword',
    isset($token) ? $token : ''
];
?>

<?= isset($last_name)? $last_name . "様" : '' ?>

案件管理システムよりパスワードリセットのご案内を申し上げます。<br/>
以下のURLよりリセットを実行いただけます。<br/>
ウェブブラウザにてご利用ください。<br/>
<?= $this->Url->build($activationUrl) ?>
