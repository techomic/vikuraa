<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddItemKitIdForeignKeyToItemKitItems extends AbstractMigration
{
    public function change(): void
    {
        $this->table('item_kit_items')
            ->addForeignKey('item_kit_id', 'item_kits', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE', 'constraint' => 'fk_item_kit_items_item_kit_id'])
            ->save();
    }
}
