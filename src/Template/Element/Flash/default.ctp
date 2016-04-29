<?php
$class = 'alert alert-';
if (!empty($params['class'])) {
    if($params['class'] == 'error') {
        $params['class'] = 'danger';
    }
    $class = $class . $params['class'];
}
?>
<div style="margin:0;" class="<?= h($class) ?>"><i class="fa fa-exclamation-circle"></i> <strong><?= __('Let op'); ?>:</strong> <?= h($message) ?></div>