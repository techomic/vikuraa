<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTableReceivingItems extends AbstractMigration
{
    public function up(): void
    {
        $this->table('receiving_items', ['id' => false, 'primary_key' => ['receiving_id', 'item_id', 'line']])
            ->addColumn('receiving_id', 'integer', ['limit' => 10, 'null' => false])
            ->addColumn('item_id', 'integer', ['limit' => 10, 'null' => false])
            ->addColumn('description', 'string', ['limit' => 30, 'null' => true])
            ->addColumn('serialnumber', 'string', ['limit' => 30, 'null' => true])
            ->addColumn('line', 'integer', ['limit' => 3, 'null' => false])
            ->addColumn('quantity_purchased', 'decimal', ['precision' => 15, 'scale' => 3, 'default' => 0.000, 'null' => false])
            ->addColumn('item_cost_price', 'decimal', ['precision' => 15, 'scale' => 2, 'null' => false])
            ->addColumn('item_unit_price', 'decimal', ['precision' => 15, 'scale' => 2, 'null' => false])
            ->addColumn('discount', 'decimal', ['precision' => 15, 'scale' => 2, 'default' => 0.00, 'null' => false])
            ->addColumn('discount_type', 'smallinteger', ['limit' => 1, 'default' => 0, 'null' => false])
            ->addColumn('item_location', 'integer', ['limit' => 11, 'null' => false])
            ->addColumn('receiving_quantity', 'decimal', ['precision' => 15, 'scale' => 3, 'default' => 1.000, 'null' => false])
            ->addIndex('item_id', ['name' => 'receiving_items_item_id'])
            ->addForeignKey('receiving_id', 'receivings', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE', 'constraint' => 'fk_receiving_items_receiving_id'])
            ->addForeignKey('item_id', 'items', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE', 'constraint' => 'fk_receiving_items_item_id'])
            ->addForeignKey('item_location', 'stock_locations', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE', 'constraint' => 'fk_receiving_items_item_location'])
            ->save();
        
        $sql = "grant select, insert, update on receiving_items to vikuraa_users";
        $this->execute($sql);

    }

    public function down(): void
    {
        $this->table('receiving_items')->drop()->save();
    }
}
