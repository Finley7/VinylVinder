<?php
use Migrations\AbstractMigration;

class CreateSubforums extends AbstractMigration
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
        $table = $this->table('subforums');
        $table->addColumn('title', 'string');
        $table->addColumn('description', 'string');
        $table->addTimestamps();
        $table->create();
    }
}
