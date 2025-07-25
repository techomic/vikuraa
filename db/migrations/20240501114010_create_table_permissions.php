<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTablePermissions extends AbstractMigration
{
    public function up(): void
    {
        $this->table('permissions', ['id' => false, 'primary_key' => 'id'])
            ->addColumn('id', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('module_id', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('location_id', 'integer', ['limit' => 10])
            ->addIndex('module_id', ['name' => 'permissions_module_id'])
            ->save();
        
        $sql = "grant select, insert, update on permissions to vikuraa_users";
        $this->execute($sql);
    }

    public function down(): void
    {
        $this->table('permissions')->drop()->save();
    }
}
