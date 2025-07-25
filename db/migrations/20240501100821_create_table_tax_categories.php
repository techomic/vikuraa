<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTableTaxCategories extends AbstractMigration
{
    public function up(): void
    {
        $this->table('tax_categories')
            ->addColumn('tax_category', 'string', ['limit' => 32, 'null' => false])
            ->addColumn('tax_group_sequence', 'smallinteger', ['null' => false])
            ->addColumn('deleted', 'boolean', ['null' => false, 'default' => false])
            ->save();
        
        $sql = "grant select, insert, update on tax_categories to vikuraa_users";
        $this->execute($sql);
    }

    public function down(): void
    {
        $this->table('tax_categories')->drop()->save();
    }
}
