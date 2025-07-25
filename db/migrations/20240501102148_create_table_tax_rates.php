<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTableTaxRates extends AbstractMigration
{
    public function up(): void
    {
        $table = $this->table('tax_rates')
            ->addColumn('code_id', 'integer', ['null' => false])
            ->addColumn('category_id', 'integer', ['null' => false])
            ->addColumn('jurisdiction_id', 'integer', ['null' => false])
            ->addColumn('rate', 'decimal', ['precision' => 15, 'scale' => 4, 'null' => false, 'default' => 0.0000])
            ->addColumn('rounding_code', 'smallinteger', ['null' => false, 'default' => 0])
            ->addIndex('category_id', ['name' => 'tax_rates_category_id'])
            ->addIndex('code_id', ['name' => 'tax_rates_code_id'])
            ->addIndex('jurisdiction_id', ['name' => 'tax_rates_jurisdiction_id'])
            ->addForeignKey('category_id', 'tax_categories', 'id', ['constraint' => 'tax_rates_ibfk_1', 'delete' => 'CASCADE', 'update' => 'NO_ACTION'])
            ->addForeignKey('code_id', 'tax_codes', 'id', ['constraint' => 'tax_rates_ibfk_2', 'delete' => 'CASCADE', 'update' => 'NO_ACTION'])
            ->addForeignKey('jurisdiction_id', 'tax_jurisdictions', 'id', ['constraint' => 'tax_rates_ibfk_3', 'delete' => 'CASCADE', 'update' => 'NO_ACTION'])
            ->save();

        $sql = "grant select, insert, update on tax_rates to vikuraa_users";
        $this->execute($sql);
    }

    public function down(): void
    {
        $this->table('tax_rates')->drop()->save();
    }
}
