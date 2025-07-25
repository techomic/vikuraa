<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTableTaxCodes extends AbstractMigration
{
    public function up(): void
    {
        $this->table('tax_codes')
            ->addColumn('tax_code', 'string', ['limit' => 32, 'null' => false])
            ->addColumn('tax_code_name', 'string', ['limit' => 255, 'null' => false, 'default' => ''])
            ->addColumn('city', 'string', ['limit' => 255, 'null' => false, 'default' => ''])
            ->addColumn('state', 'string', ['limit' => 255, 'null' => false, 'default' => ''])
            ->addColumn('deleted', 'boolean', ['null' => false, 'default' => false])
            ->save();
        
        $sql = "grant select, insert, update on tax_codes to vikuraa_users";
        $this->execute($sql);
    }

    public function down(): void
    {
        $this->table('tax_codes')->drop()->save();
    }
}
