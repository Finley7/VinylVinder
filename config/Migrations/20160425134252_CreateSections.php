<?php
use Migrations\AbstractMigration;

class CreateSections extends AbstractMigration
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
        $table = $this->table('sections');
        $table->addColumn('name', 'string');
        $table->addColumn('description', 'string');
        $table->create();
    }
}
