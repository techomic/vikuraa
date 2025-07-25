<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTableItemQuantities extends AbstractMigration
{
    public function up(): void
    {
        $this->table('item_quantities', ['id' => false, 'primary_key' => ['item_id', 'location_id']])
            ->addColumn('item_id', 'integer', ['limit' => 11, 'null' => false])
            ->addColumn('location_id', 'integer', ['limit' => 11, 'null' => false])
            ->addColumn('quantity', 'decimal', ['precision' => 15, 'scale' => 3, 'null' => false, 'default' => 0.000])
            ->addIndex('item_id', ['name' => 'item_quantities_item_id'])
            ->addIndex('location_id', ['name' => 'item_quantities_location_id'])
            ->addForeignKey('item_id', 'items', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE', 'constraint' => 'fk_item_quantities_item_id'])
            ->addForeignKey('location_id', 'stock_locations', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE', 'constraint' => 'fk_item_quantities_location_id'])
            ->save();
        
        $sql = "grant select, insert, update on item_quantities to vikuraa_users";
        $this->execute($sql);
    }

    public function down(): void
    {
        $this->table('item_quantities')->drop()->save();
    }
}
