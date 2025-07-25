<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTableSaleItemTaxes extends AbstractMigration
{
    // TODO: check if sale_tax_code_id is a foreign key
    public function up(): void
    {
        $this->table('sale_item_taxes', ['id' => false, 'primary_key' => ['sale_id', 'item_id', 'line', 'name', 'percent']])
            ->addColumn('sale_id', 'integer', ['limit' => 10, 'null' => false])
            ->addColumn('item_id', 'integer', ['limit' => 10, 'null' => false])
            ->addColumn('line', 'integer', ['limit' => 3, 'default' => 0, 'null' => false])
            ->addColumn('name', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('percent', 'decimal', ['precision' => 15, 'scale' => 4, 'default' => 0.0000, 'null' => false])
            ->addColumn('tax_type', 'smallinteger', ['limit' => 1, 'default' => 0, 'null' => false])
            ->addColumn('rounding_code', 'smallinteger', ['limit' => 1, 'default' => 0, 'null' => false])
            ->addColumn('cascade_sequence', 'smallinteger', ['limit' => 1, 'default' => 0, 'null' => false])
            ->addColumn('item_tax_amount', 'decimal', ['precision' => 15, 'scale' => 4, 'default' => 0.0000, 'null' => false])
            ->addColumn('sales_tax_code_id', 'integer', ['limit' => 11, 'null' => true])
            ->addColumn('jurisdiction_id', 'integer', ['limit' => 11, 'null' => true])
            ->addColumn('tax_category_id', 'integer', ['limit' => 11, 'null' => true])
            ->addIndex('sale_id', ['name' => 'sale_item_taxes_sale_id'])
            ->addIndex('item_id', ['name' => 'sale_item_taxes_item_id'])
            ->addForeignKey('sale_id', 'sales', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE', 'constraint' => 'fk_sale_item_taxes_sale_id'])
            ->addForeignKey('item_id', 'items', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE', 'constraint' => 'fk_sale_item_taxes_item_id'])
            ->addForeignKey('jurisdiction_id', 'tax_jurisdictions', 'id', ['delete' => 'SET_NULL', 'update' => 'CASCADE', 'constraint' => 'fk_sale_item_taxes_jurisdiction_id'])
            ->addForeignKey('tax_category_id', 'tax_categories', 'id', ['delete' => 'SET_NULL', 'update' => 'CASCADE', 'constraint' => 'fk_sale_item_taxes_tax_category_id'])
            ->save();

        $sql = "grant select, insert, update, delete on sale_item_taxes to vikuraa_users";
        $this->execute($sql);
    }

    public function down(): void
    {
        $this->table('sale_item_taxes')->drop()->save();
    }
}
