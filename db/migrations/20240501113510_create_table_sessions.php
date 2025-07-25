<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTableSessions extends AbstractMigration
{
    public function up(): void
    {
        $this->table('sessions', ['id' => false, 'primary_key' => 'id'])
            ->addColumn('id', 'string', ['limit' => 40, 'null' => false])
            ->addColumn('ip_address', 'string', ['limit' => 45, 'null' => false])
            ->addColumn('timestamp', 'integer', ['limit' => 10, 'signed' => false, 'default' => 0])
            ->addColumn('data', 'text', ['null' => false])
            ->addIndex('timestamp', ['name' => 'sessions_timestamp'])
            ->addIndex('ip_address', ['name' => 'sessions_ip_address'])
            ->save();
        
        $sql = "grant select, insert, update on sessions to vikuraa_users";
        $this->execute($sql);
    }

    public function down(): void
    {
        $this->table('sessions')->drop()->save();
    }
}
