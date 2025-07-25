<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTableEmployees extends AbstractMigration
{
    public function up(): void
    {
        $table = $this->table('employees', ['id' => false, 'primary_key' => 'person_id']);
        $table->addColumn('person_id', 'integer', ['null' => false])
            ->addColumn('username', 'string', ['limit' => 255, 'null' => false])
            // ->addColumn('password', 'string', ['limit' => 255, 'null' => false]) // Password will be managed on the postgres server
            ->addColumn('deleted', 'boolean', ['null' => false, 'default' => 0])
            ->addColumn('hash_version', 'smallinteger', ['null' => false, 'default' => 2])
            ->addColumn('language', 'string', ['limit' => 48, 'null' => true])
            ->addColumn('language_code', 'string', ['limit' => 8, 'null' => true])
            ->addIndex(['username'], ['unique' => true])
            ->addIndex(['person_id'])
            ->save();

        $sql = "grant select, insert, update on employees to vikuraa_users";
        $this->execute($sql);
    }

    public function down(): void
    {
        $this->table('employees')->drop()->save();
    }
}
