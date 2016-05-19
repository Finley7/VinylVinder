<div class="col-md-3">
    <div class="card">
        <div class="card-header card-primary">
            Menu
        </div>
        <ul class="list-group">
            <?= $this->Html->link('Verander avatar', [
                'controller' => 'Users',
                'action' => 'avatar'
            ], ['class' => 'list-group-item']); ?>
            <?= $this->Html->link('Verander handtekening', [
                'controller' => 'Users',
                'action' => 'autograph'
            ], ['class' => 'list-group-item']); ?>
        </ul>

    </div>
</div>