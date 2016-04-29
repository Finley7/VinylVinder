<?php
$this->Html->addCrumb('Forum index', '/forums');
$this->Html->addCrumb($thread->forum->name, "/forums/view/{$thread->forum->id}");
$this->Html->addCrumb($thread->title);
?>

<section class="main">
    <div class="container"
    <div class="row">
        <?php if ($this->Paginator->current() == 1): ?>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-primary">
                    <?= $thread->title; ?>
                </div>
                <div class="card-block">
                    <div class="media">
                        <div class="media-left text-md-center">
                            <?= $this->Html->image('uploads/avatars/' . $thread->user->avatar, [
                                'class' => 'img-circle avatar',
                            ]); ?>
                            <br>
                            <span style="font-size:18px;" class="<?= $thread->user->primary_role->name; ?>">
                                <?= $thread->user->username; ?>
                            </span>
                            <br>
                            <span
                                class="label label-default label-<?= $thread->user->primary_role->name; ?>"><?= $thread->user->primary_role->name; ?></span>
                        </div>
                        <div class="media-body" style="padding:0px 10px;">
                            <small class="text-muted">
                                <?= __('Aangemaakt op {0}', $thread->created_at->nice()); ?>
                                <?php if(!is_null($thread->edit_by)): ?>
                                    <?= __('(Bewerkt, {0} door {1})', [$thread->updated_at->timeAgoInWords(), $thread->editor->username]); ?>
                                <?php endif; ?>
                            </small>
                            <div class="pull-right">

                            </div>
                            <hr>
                            <?= $this->Ubb->parse($thread->body); ?>
                        </div>
                    </div>
                </div>
                <div class="card-footer">

                    <?= $this->Html->link('<i class="fa fa-anchor"></i>', [
                        'action' => 'view',
                        $thread->id,
                        $thread->slug,
                        '?' => ['page' => $this->Paginator->current],
                        '#' => 'pid' . $thread->id
                    ], [
                        'class' => 'btn btn-sm btn-primary',
                        'escape' => false
                    ]); ?>
                    <?php if ($user->hasPermission('mod_index')): ?>
                        <?= $this->Form->postLink('<i class="fa fa-lock"></i>', [
                            'controller' => 'Threads',
                            'action' => 'close',
                            'prefix' => 'mod',
                            $thread->id,
                        ], [
                            'class' => 'btn btn-sm btn-warning',
                            'escape' => false
                        ]); ?>
                    <?php endif; ?>
                    <?php if($thread->user->id == $user->id): ?>
                        <?= $this->Html->link('<i class="fa fa-pencil-square-o"></i>', [
                            'controller' => 'Threads',
                            'action' => 'edit',
                            $thread->id,
                        ], [
                            'class' => 'btn btn-sm btn-info',
                            'escape' => false
                        ]); ?>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
            <?php foreach ($replies as $comment): ?>
                <?php if (!$comment->deleted): ?>
                    <div class="card card-block" id="pid<?= $comment->id; ?>">
                        <div class="media">
                            <div class="media-left text-md-center">
                                <?= $this->Html->image('uploads/avatars/' . $comment->user->avatar, [
                                    'class' => 'img-circle avatar',
                                ]); ?>
                                <br>
                            <span style="font-size:18px;"
                                  class="<?= $comment->user->primary_role->name; ?>"><?= $comment->user->username; ?></span>
                                <br>
                            <span
                                class="label label-default label-<?= $comment->user->primary_role->name; ?>"><?= $comment->user->primary_role->name; ?></span>
                            </div>
                            <div class="media-body" style="padding:0px 10px;">
                                <small
                                    class="text-muted"><?= __('Geplaatst {0}', $comment->created_at->timeAgoInWords()); ?></small>
                                <div class="pull-right">
                                    <?= $this->Html->link('<i class="fa fa-anchor"></i>', [
                                        'action' => 'view',
                                        $thread->id,
                                        $thread->slug,
                                        '?' => ['page' => $this->Paginator->current()],
                                        '#' => 'pid' . $comment->id
                                    ], [
                                        'class' => 'btn btn-xs btn-primary',
                                        'escape' => false
                                    ]); ?>
                                    <?= $this->Html->link('<i class="fa fa-quote-left"></i>', [
                                        'controller' => 'Comments',
                                        'action' => 'quote',
                                        $thread->id,
                                        $comment->id,
                                    ], [
                                        'class' => 'btn btn-xs btn-info',
                                        'escape' => false
                                    ]); ?>
                                    <?php if ($comment->user->id == $user->id || $user->hasPermission('mod_index')): ?>
                                        <?= $this->Html->link('<i class="fa fa-pencil-square"></i>', [
                                            'controller' => 'Comments',
                                            'action' => 'edit',
                                            $thread->id,
                                        ], [
                                            'class' => 'btn btn-xs btn-warning',
                                            'escape' => false
                                        ]); ?>
                                    <?php endif; ?>
                                    <?php if ($user->hasPermission('mod_index')): ?>
                                        <?= $this->Form->postLink('<i class="fa fa-trash"></i>', [
                                            'controller' => 'Comments',
                                            'action' => 'delete',
                                            'prefix' => 'mod',
                                            $thread->id,
                                        ], [
                                            'class' => 'btn btn-xs btn-danger',
                                            'escape' => false
                                        ]); ?>
                                    <?php endif; ?>
                                </div>
                                <hr>
                                <?= $this->Ubb->parse($comment->body); ?>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <?php if ($user->hasPermission('mod_index')): ?>
                        <div class="card card-block" style="background:#ffcccc" id="pid<?= $comment->id; ?>">
                            <div class="media">
                                <div class="media-left text-md-center">
                                    <?= $this->Html->image('uploads/avatars/' . $comment->user->avatar, [
                                        'class' => 'img-circle avatar',
                                    ]); ?>
                                    <br>
                            <span style="font-size:18px;"
                                  class="<?= $comment->user->primary_role->name; ?>"><?= $comment->user->username; ?></span>
                                    <br>
                            <span
                                class="label label-default label-<?= $comment->user->primary_role->name; ?>"><?= $comment->user->primary_role->name; ?></span>
                                </div>
                                <div class="media-body" style="padding:0px 10px;">
                                    <small
                                        class="text-muted"><?= __('Geplaatst {0}', $comment->created_at->timeAgoInWords()); ?></small>
                                    <div class="pull-right">
                                        <?= $this->Html->link('<i class="fa fa-anchor"></i>', [
                                            'action' => 'view',
                                            $thread->id,
                                            $thread->slug,
                                            '?' => ['page' => $this->Paginator->current()],
                                            '#' => 'pid' . $comment->id
                                        ], [
                                            'class' => 'btn btn-xs btn-primary',
                                            'escape' => false
                                        ]); ?>
                                        <?php if ($comment->user->id == $user->id): ?>
                                            <?= $this->Html->link('<i class="fa fa-pencil-square"></i>', [
                                                'controller' => 'Comments',
                                                'action' => 'edit',
                                                $thread->id,
                                            ], [
                                                'class' => 'btn btn-xs btn-warning',
                                                'escape' => false
                                            ]); ?>
                                        <?php endif; ?>
                                    </div>
                                    <hr>
                                    <?= $this->Ubb->parse($comment->body); ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endforeach; ?>
            <nav style="margin:0;padding:0;">
                <ul class="pagination pagination-sm">
                    <li class="page-item">
                        <?= $this->Paginator->prev(__('Back'), ['class' => 'page-link']) ?>
                    </li>
                    <li class="page-item">
                        <?= $this->Paginator->numbers(['class' => 'page-link']); ?>
                    </li>
                    <li class="page-item">
                        <?= $this->Paginator->next(__('Next'), ['class' => 'page-link']) ?>
                    </li>
                </ul>
            </nav>
            <hr>
            <div class="card">
                <div class="card-header card-primary">
                    <?= __('Plaats een reactie'); ?>
                    <?= $this->Html->link(__('Uitgebreide reacte'), [
                        'controller' => 'Comments',
                        'action' => 'add',
                        $thread->id
                    ], ['class' => 'btn btn-xs btn-success pull-right']); ?>
                </div>
                <div class="card-block">
                    <?php if (!$thread->closed): ?>
                        <?= $this->Form->create(null, [
                            'url' => [
                                'controller' => 'Comments',
                                'action' => 'add',
                                $thread->id
                            ]
                        ]); ?>
                        <fieldset class="form-group">
                            <?= $this->Form->textarea('body', [
                                'label' => __('Reactie'),
                                'placeholder' => __('Plaats een reactie'),
                                'class' => 'form-control'
                            ]); ?>
                        </fieldset>
                        <fieldset class="form-group">
                            <?php if($user->hasPermission('mod_index')): ?>
                            <label class="c-input c-checkbox">
                                <input name="close" type="checkbox">
                                <span class="c-indicator"></span>
                                Sluit dit topic
                            </label>
                            <?php endif; ?>
                            <?= $this->Form->submit(__('Plaats reactie'), ['class' => 'btn btn-primary pull-right']); ?>
                        </fieldset>


                        <?= $this->Form->end(); ?>
                    <?php else: ?>
                        <div class="alert alert-danger"><?= __('Sorry, maar deze thread is gesloten!'); ?></div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
    </div>
</section>
<script>
    SyntaxHighlighter.all();
</script>