<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTablePeople extends AbstractMigration
{

    public function up(): void
    {
        $table = $this->table('people', ['id' => false, 'primary_key' => 'person_id']);
        $table->addColumn('person_id', 'integer', ['identity' => true])
            ->addColumn('first_name', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('last_name', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('gender', 'char', ['null' => true, 'limit' => 1])
            ->addColumn('phone_number', 'string', ['limit' => 20, 'null' => false])
            ->addColumn('email', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('address_1', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('address_2', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('city', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('state', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('zip', 'string', ['limit' => 50, 'null' => false])
            ->addColumn('country', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('comments', 'text', ['null' => false])
            ->addColumn('created_at', 'datetime', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
            ->addIndex(['email'], ['unique' => true])
            ->save();
        
            $sql = "grant select, insert, update on people to vikuraa_users";
            $this->execute($sql);
    }

    public function down(): void
    {
        $this->table('people')->drop()->save();
    }
}
