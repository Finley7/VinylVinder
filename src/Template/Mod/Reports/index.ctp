<section class="main">
    <div class="container">
        <?= $this->element('Menu/mod_menu', ['pageParent' => 'dashboard']); ?>
        <div style="margin-top:15px;" class="col-md-9">
            <div class="card">
                <div class="card-header card-primary">
                    Bekijk gerapporteerde berichten
                </div>
                <div class="card-block">
                    <?php foreach($reports as $report): ?>
                        <?= debug($report); ?>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>
    </div>
</section>
