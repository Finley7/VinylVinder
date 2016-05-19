<?php
use Migrations\AbstractMigration;

class CreateUserPreferences extends AbstractMigration
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
        $table = $this->table('user_preferences');
        $table->addColumn('show_email', 'boolean', ['default' => false]);
        $table->addColumn('dob', 'datetime');
        $table->addColumn('receive_pms', 'boolean', ['default' => false]);
        $table->create();
    }
}
