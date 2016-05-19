<?php
use Cake\Core\Configure;
if (Configure::read('debug')):
    $this->layout = 'dev_error';
    $this->assign('title', $message);
    $this->assign('templateName', 'error400.ctp');
    $this->start('file');
    ?>
    <?php if (!empty($error->queryString)) : ?>
    <p class="notice">
        <strong>SQL Query: </strong>
        <?= h($error->queryString) ?>
    </p>
<?php endif; ?>
    <?php if (!empty($error->params)) : ?>
    <strong>SQL Query Params: </strong>
    <?= Debugger::dump($error->params) ?>
<?php endif; ?>
    <?= $this->element('auto_table_warning') ?>
    <?php
    if (extension_loaded('xdebug')):
        xdebug_print_function_stack();
    endif;
    $this->end();
endif;
?>
<div class="container">
    <div class="row">
        <div style="margin:10px;" class="col-md-12">
            <div class="card card-block">
                <h2 class="card-title"><?= h($message) ?></h2>
                <p class="error">
                    <strong><?= __d('cake', 'Error') ?>: </strong>
                    <?= sprintf(
                        __d('cake', 'The requested address %s was not found on this server.'),
                        "<strong>'{$url}'</strong>"
                    ) ?>
                </p>
            </div>
        </div>
    </div>
</div>