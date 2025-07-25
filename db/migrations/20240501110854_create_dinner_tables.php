<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateDinnerTables extends AbstractMigration
{
    public function up(): void
    {
        $table = $this->table('dinner_tables')
            ->addColumn('name', 'string', ['null' => false, 'limit' => 30])
            ->addColumn('status', 'boolean', ['null' => false, 'default' => 0])
            ->addColumn('deleted', 'boolean', ['null' => false, 'default' => 0])
            ->addIndex('status', ['name' => 'dinner_tables_status'])
            ->save();

        $sql = "grant select, insert, update on dinner_tables to vikuraa_users";
        $this->execute($sql);
    }

    public function down(): void
    {
        $this->table('dinner_tables')->drop()->save();
    }
}
