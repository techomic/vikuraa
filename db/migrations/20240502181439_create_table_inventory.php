<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTableInventory extends AbstractMigration
{
    public function up(): void
    {
        $this->table('inventory')
            ->addColumn('items', 'integer', ['limit' => 11, 'null' => false, 'default' => 0])
            ->addColumn('user', 'integer', ['limit' => 11, 'null' => false, 'default' => 0])
            ->addColumn('date', 'timestamp', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('comment', 'text', ['null' => false])
            ->addColumn('location', 'integer', ['limit' => 11, 'null' => false])
            ->addColumn('inventory', 'decimal', ['precision' => 15, 'scale' => 3, 'null' => false, 'default' => 0.000])
            ->addIndex('items', ['name' => 'inventory_name'])
            ->addIndex('user', ['name' => 'inventory_user'])
            ->addIndex('location', ['name' => 'inventory_location'])
            ->addIndex('date', ['name' => 'inventory_date'])
            ->save();
        
        $sql = "grant select, insert, update on inventory to vikuraa_users";
        $this->execute($sql);
    }

    public function down(): void
    {
        $this->table('inventory')->drop()->save();
    }
}
