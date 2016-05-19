<?php
use Migrations\AbstractMigration;

class CreateThreads extends AbstractMigration
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
        $table = $this->table('threads');
        $table->addColumn('title', 'string');
        $table->addColumn('body', 'text');
        $table->addTimestamps();
        $table->create();
    }
}
