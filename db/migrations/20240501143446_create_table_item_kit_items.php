<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTableItemKitItems extends AbstractMigration
{
    public function up(): void
    {
        $this->table('item_kit_items', ['id' => false, 'primary_key' => ['item_kit_id', 'item_id', 'quantity']])
            ->addColumn('item_kit_id', 'integer', ['null' => false])
            ->addColumn('item_id', 'integer', ['null' => false])
            ->addColumn('quantity', 'decimal', ['precision' => 15, 'scale' => 3, 'null' => false])
            ->addColumn('kit_sequence', 'integer', ['null' => false, 'default' => 0])
            ->addForeignKey('item_id', 'items', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE', 'constraint' => 'fk_item_kit_items_item_id'])
            ->create();
    }

    public function down(): void
    {
        $this->table('item_kit_items')->drop()->save();
    }
}
