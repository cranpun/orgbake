<?php
$class = 'alert-info';
if (!empty($params['class'])) {
    $class .= ' ' . $params['class'];
}
?>
<div class="alert <?= h($class) ?>" onclick="this.classList.add('hidden')"><?= h($message) ?></div>
