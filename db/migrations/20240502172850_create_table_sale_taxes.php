<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTableSaleTaxes extends AbstractMigration
{
    public function up(): void
    {
        $this->table('sale_taxes')
            ->addColumn('sale_id', 'integer', ['signed' => false, 'null' => false])
            ->addColumn('jurisdiction_id', 'integer', ['null' => true, 'signed' => false])
            ->addColumn('tax_category_id', 'integer', ['null' => true, 'signed' => false])
            ->addColumn('tax_type', 'smallinteger', ['null' => false])
            ->addColumn('tax_group', 'string', ['limit' => 32, 'null' => false])
            ->addColumn('sale_tax_basis', 'decimal', ['precision' => 15, 'scale' => 4, 'null' => false])
            ->addColumn('sale_tax_amount', 'decimal', ['precision' => 15, 'scale' => 4, 'null' => false])
            ->addColumn('print_sequence', 'smallinteger', ['default' => 0, 'null' => false])
            ->addColumn('name', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('tax_rate', 'decimal', ['precision' => 15, 'scale' => 4, 'null' => false])
            ->addColumn('sales_tax_code_id', 'integer', ['null' => true, 'signed' => false])
            ->addColumn('rounding_code', 'smallinteger', ['default' => 0, 'null' => false])
            ->addIndex(['sale_id', 'print_sequence', 'tax_group'], ['name' => 'sale_taxes_print_sequence'])
            ->addForeignKey('sale_id', 'sales', 'id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION', 'constraint' => 'fk_sale_taxes_sale_id'])
            ->addForeignKey('jurisdiction_id', 'tax_jurisdictions', 'id', ['delete' => 'SET_NULL', 'update' => 'NO_ACTION', 'constraint' => 'fk_sale_taxes_jurisdiction_id'])
            ->save();
        $sql = "grant select, insert, update, delete on sale_taxes to vikuraa_users";
        $this->execute($sql);
    }

    public function down(): void
    {
        $this->table('sale_taxes')->drop()->save();
    }
}
