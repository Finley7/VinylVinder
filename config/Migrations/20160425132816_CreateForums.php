<?php
use Migrations\AbstractMigration;

class CreateForums extends AbstractMigration
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
        $table = $this->table('forums');
        $table->addColumn('name', 'string');
        $table->addColumn('description', 'string');
        $table->addColumn('min_role', 'integer');
        $table->addTimestamps();
        $table->create();
    }
}
