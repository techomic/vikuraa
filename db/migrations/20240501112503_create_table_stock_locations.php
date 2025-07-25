<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTableStockLocations extends AbstractMigration
{
    public function up(): void
    {
        $this->table('stock_locations')
            ->addColumn('location_name', 'string', ['limit' => 255])
            ->addColumn('deleted', 'boolean', ['default' => false])
            ->save();
        $sql = "grant select, insert, update on stock_locations to vikuraa_users";
        $this->execute($sql);
    }

    public function down(): void
    {
        $this->table('stock_locations')->drop()->save();
    }
}
