<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTableSaleItems extends AbstractMigration
{
    public function up(): void
    {
        $this->table('sale_items', ['id' => false, 'primary_key' => ['sale_id', 'item_id', 'line']])
            ->addColumn('sale_id', 'integer', ['null' => false])
            ->addColumn('item_id', 'integer', ['null' => false])
            ->addColumn('description', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('serialnumber', 'string', ['limit' => 30, 'null' => true])
            ->addColumn('line', 'integer', ['null' => false, 'default' => 0])
            ->addColumn('quantity_purchased', 'decimal', ['precision' => 15, 'scale' => 3, 'null' => false, 'default' => 0.000])
            ->addColumn('item_cost_price', 'decimal', ['precision' => 15, 'scale' => 2, 'null' => false])
            ->addColumn('item_unit_price', 'decimal', ['precision' => 15, 'scale' => 2, 'null' => false])
            ->addColumn('discount', 'decimal', ['precision' => 15, 'scale' => 2, 'null' => false, 'default' => 0.00])
            ->addColumn('discount_type', 'smallinteger', ['null' => false, 'default' => 0])
            ->addColumn('item_location', 'integer', ['null' => false])
            ->addColumn('print_option', 'smallinteger', ['null' => false, 'default' => 0])
            ->addForeignKey('sale_id', 'sales', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE', 'constraint' => 'fk_sales_items_sale_id'])
            ->addForeignKey('item_id', 'items', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE', 'constraint' => 'fk_sales_items_item_id'])
            ->addForeignKey('item_location', 'stock_locations', 'id', ['delete' => 'RESTRICT', 'update' => 'CASCADE', 'constraint' => 'fk_sales_items_item_location'])
            ->save();
        
        $this->execute('GRANT SELECT, INSERT, UPDATE ON sale_items TO vikuraa_users');
    }

    public function down(): void
    {
        $this->table('sale_items')->drop()->save();
    }
}
