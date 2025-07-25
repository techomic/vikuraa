<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTableItemTaxes extends AbstractMigration
{
    public function up(): void
    {
        $this->table('item_taxes', ['id' => false, 'primary_key' => ['item_id', 'name', 'percent']])
            ->addColumn('item_id', 'integer', ['null' => false])
            ->addColumn('name', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('percent', 'decimal', ['precision' => 15, 'scale' => 3, 'null' => false])
            ->addForeignKey('item_id', 'items', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE', 'constraint' => 'fk_item_taxes_item_id'])
            ->save();
        
        $this->execute('GRANT SELECT, INSERT, UPDATE ON item_taxes TO vikuraa_users');
    }

    public function down(): void
    {
        $this->table('item_taxes')->drop()->save();
    }
}
