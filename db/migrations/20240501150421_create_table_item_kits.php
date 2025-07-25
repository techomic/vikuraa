<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTableItemKits extends AbstractMigration
{
    /*
    CREATE TABLE `vikuraa_item_kits` (
        KEY `item_kit_number` (`item_kit_number`),
        KEY `name` (`name`,`description`)
    );
    */
    public function up(): void
    {
        $this->table('item_kits')
            ->addColumn('item_kit_number', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('name', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('item_id', 'integer', ['null' => false])
            ->addColumn('kit_discount', 'decimal', ['precision' => 15, 'scale' => 2, 'null' => false, 'default' => 0.00])
            ->addColumn('kit_discount_type', 'smallinteger', ['null' => false, 'default' => 0])
            ->addColumn('price_option', 'smallinteger', ['null' => false, 'default' => 0])
            ->addColumn('print_option', 'smallinteger', ['null' => false, 'default' => 0])
            ->addColumn('description', 'string', ['limit' => 255, 'null' => false])
            ->addIndex('item_kit_number', ['name' => 'item_kit_item_kit_number'])
            ->addIndex(['name', 'description'], ['name' => 'item_kit_name_description'])
            ->save();
        
        $this->execute('GRANT SELECT, INSERT, UPDATE ON item_kits TO vikuraa_users');
    }

    public function down(): void
    {
        $this->table('item_kits')->drop()->save();
    }
}
