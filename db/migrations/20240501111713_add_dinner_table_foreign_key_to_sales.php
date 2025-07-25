<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddDinnerTableForeignKeyToSales extends AbstractMigration
{
    public function change(): void
    {
        $this->table('sales')
            ->addForeignKey('dinner_table_id', 'dinner_tables', 'id', ['constraint' => 'fk_sales_dinner_table_id', 'delete' => 'CASCADE', 'update' => 'CASCADE'])
            ->save();
    }
}
