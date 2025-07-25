<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTableItems extends AbstractMigration
{
    // TODO: add supplier_id foreign key
    // TODO: add tax_category_id foreign key
    public function up(): void
    {
        $this->table('items')
            ->addColumn('name', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('category', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('supplier_id', 'integer')
            ->addColumn('item_number', 'string', ['limit' => 255])
            ->addColumn('description', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('cost_price', 'decimal', ['precision' => 15, 'scale' => 2, 'null' => false])
            ->addColumn('unit_price', 'decimal', ['precision' => 15, 'scale' => 2, 'null' => false])
            ->addColumn('reorder_level', 'decimal', ['precision' => 15, 'scale' => 3, 'null' => false, 'default' => 0.000])
            ->addColumn('receiving_quantity', 'decimal', ['precision' => 15, 'scale' => 3, 'null' => false, 'default' => 1.000])
            ->addColumn('pic_filename', 'string', ['limit' => 255])
            ->addColumn('allow_alt_description', 'boolean', ['null' => false])
            ->addColumn('is_serialized', 'boolean', ['null' => false])
            ->addColumn('stock_type', 'boolean', ['null' => false, 'default' => false])
            ->addColumn('item_type', 'smallinteger', ['null' => false, 'default' => 0])
            ->addColumn('deleted', 'boolean', ['null' => false, 'default' => false])
            ->addColumn('tax_category_id', 'integer')
            ->addColumn('qty_per_pack', 'decimal', ['precision' => 15, 'scale' => 3, 'null' => false, 'default' => 1.000])
            ->addColumn('pack_name', 'string', ['limit' => 8, 'default' => 'Each'])
            ->addColumn('low_sell_item_id', 'integer', ['default' => 0])
            ->addColumn('hsn_code', 'string', ['limit' => 32, 'null' => false, 'default' => ''])
            ->addIndex(['supplier_id', 'id', 'deleted', 'item_type'], ['unique' => true, 'name' => 'items_uq1'])
            ->addIndex(['item_number'], ['name' => 'items_item_number'])
            ->addIndex(['supplier_id'], ['name' => 'items_supplier_id'])
            ->addIndex(['deleted', 'item_type'], ['name' => 'items_deleted'])
            ->save();
        
        $sql = "grant select, insert, update, delete on items to vikuraa_users";
        $this->execute($sql);
    }

    public function down(): void
    {
        $this->table('items')->drop()->save();
    }
}
