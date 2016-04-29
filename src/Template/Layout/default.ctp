<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        VinylVinder |
        <?= isset($title) ? $title : $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('bootstrap.min.css') ?>
    <?= $this->Html->css('shCore.css') ?>
    <?= $this->Html->css('shThemeDefault.css') ?>
    <?= $this->Html->css('font-awesome.min.css') ?>
    <?= $this->Html->css('base.css') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

    <?= $this->Html->css('wbbtheme.css'); ?>
    <?= $this->Html->script('jquery.wysibb.min.js'); ?>
    <?= $this->Html->script('shCore.js'); ?>
    <?= $this->Html->script('shLegacy.js'); ?>
    <?= $this->Html->script('shBrushPhp.js'); ?>
</head>
<body>
<?= $this->Flash->render() ?>
<?= $this->Flash->render('auth') ?>
<nav class="navbar navbar-dark" style="background:#5183b2;border-radius:0;">
    <div class="container">
        <?= $this->Html->link("<i class=\"fa fa-play-circle\"></i> VinylVinder</a>", [
            'controller' => 'Pages',
            'action' => 'landing'
        ], [
            'class' => 'navbar-brand',
            'escape' => false
        ]); ?>
        <ul class="nav navbar-nav pull-right">
            <li class="<?= ($page_parent == 'home') ? 'nav-item active' : 'nav-item'; ?>">
                <?= $this->Html->link(__(' Home'), [
                    'controller' => 'Pages',
                    'action' => 'landing'
                ], [
                    'class' => 'nav-link',
                    'id' => 'home'
                ]); ?>

            </li>
            <li class="<?= ($page_parent == 'search') ? 'nav-item active' : 'nav-item'; ?>">
                <?= $this->Html->link(__(' Zoeken'), [
                    'controller' => 'Search',
                    'action' => 'index'
                ], [
                    'class' => 'nav-link',
                    'id' => 'search'
                ]); ?>
            </li>
            <li class="nav-item <?= ($page_parent == 'community') ? 'nav-item active' : 'nav-item'; ?>">
                <?= $this->Html->link(__(' Community'), [
                    'controller' => 'Forums',
                    'action' => 'index'
                ], [
                    'class' => 'nav-link',
                    'id' => 'community'
                ]); ?>
            </li>
            <li class="nav-item <?= ($page_parent == 'user') ? 'nav-item active' : 'nav-item'; ?>">
                <?php if (isset($user->id)): ?>
                    <?= $this->Html->link(' ' . $user->username, [
                        'controller' => 'Users',
                        'action' => 'view',
                        $user->id
                    ], [
                        'class' => 'nav-link',
                        'id' => 'user'
                    ]); ?>
                <?php else: ?>
                    <?= $this->Html->link(__(' Aanmelden'), [
                        'controller' => 'Users',
                        'action' => 'login'
                    ], [
                        'class' => 'nav-link',
                        'id' => 'user'
                    ]); ?>
                <?php endif; ?>
            </li>
            <?php if (!isset($user->id)): ?>
                <li class="nav-item <?= ($page_parent == 'add') ? 'nav-item active' : 'nav-item'; ?>">
                    <?php if (\Cake\Core\Configure::read('App.can_register')): ?>
                        <?= $this->Html->link(__(' Maak een account'), [
                            'controller' => 'Users',
                            'action' => 'add'
                        ], [
                            'class' => 'nav-link',
                            'id' => 'add'
                        ]); ?>
                    <?php endif ?>
                </li>
            <?php endif; ?>
            <li class="nav-item <?= ($page_parent == 'settings') ? 'nav-item active' : 'nav-item'; ?>">
                <?php if (isset($user->id)): ?>
                    <?= $this->Html->link('<i class="fa fa-gear"></i>', [
                        'controller' => 'Users',
                        'action' => 'settings',
                    ], [
                        'class' => 'nav-link',
                        'escape' => false
                    ]); ?>
                <?php endif; ?>
            </li>
        </ul>
    </div>
</nav>
<?php if ($page_parent == 'community'): ?>
    <section class="brcrmb">
        <div class="container">
            <div class="col-md-12">
                <?= $this->Html->getCrumbList([
                    'lastClass' => 'active',
                    'class' => 'breadcrumb'
                ], 'Homepagina'); ?>
            </div>
        </div>
    </section>
<?php endif; ?>
<?= $this->fetch('content') ?>
<footer>
    <div class="container">
        <div class="col-md-12">
            <div class="row">
                <div class="card card-block">
                    <?php if(isset($user->id)): ?>
                    <span class="pull-right">
                        <span class="text-muted">Ingelogd als <?= $user->username; ?> | </span>
                        <?= $this->Form->postLink('Uitloggen', ['controller' => 'Users', 'action' => 'logout'], ['class' => 'btn btn-xs btn-primary-outline']); ?>
                    </span>
                    <?php endif; ?>
                    Copyright &copy; 2016 VinylVinder - Alle rechten voorbehouden.
                </div>
            </div>
        </div>
    </div>
</footer>
</body>
</html>
