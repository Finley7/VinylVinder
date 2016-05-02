<?php
use Migrations\AbstractMigration;

class CreateReports extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('reports');
        $table->addColumn('reason', 'string');
        $table->addColumn('handled', 'boolean');
        $table->addTimestamps();
        $table->create();
    }
}
