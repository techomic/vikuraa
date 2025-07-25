<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTableAttributeLinks extends AbstractMigration
{
    public function up(): void
    {
        $this->table('attribute_links', ['id' => false])
            ->addColumn('attribute_id', 'integer')
            ->addColumn('definition_id', 'integer')
            ->addColumn('item_id', 'integer')
            ->addColumn('sale_id', 'integer')
            ->addColumn('receiving_id', 'integer')
            ->addIndex(['attribute_id', 'definition_id','item_id','sale_id','receiving_id'], ['name' => 'attribute_links_uq1', 'unique' => true])
            ->addIndex(['item_id', 'sale_id','receiving_id','definition_id','attribute_id'], ['name' => 'attribute_links_uq2', 'unique' => true])
            ->addIndex('attribute_id', ['name' => 'attribute_links_attribute_id'])
            ->addIndex('definition_id', ['name' => 'attribute_links_definition_id'])
            ->addIndex('item_id', ['name' => 'attribute_links_item_id'])
            ->addIndex('sale_id', ['name' => 'attribute_links_sale_id'])
            ->addIndex('receiving_id', ['name' => 'attribute_links_receiving_id'])
            ->addForeignKey('definition_id', 'attribute_definitions', 'id', ['delete' => 'CASCADE', 'constraint' => 'attribute_links_ibfk_1'])
            ->addForeignKey('attribute_id', 'attribute_values', 'id', ['delete' => 'CASCADE', 'constraint' => 'attribute_links_ibfk_2'])
            ->addForeignKey('item_id', 'items', 'id', ['constraint' => 'attribute_links_ibfk_3'])
            ->addForeignKey('receiving_id', 'receivings', 'id', ['delete' => 'CASCADE', 'constraint' => 'attribute_links_ibfk_4'])
            ->addForeignKey('sale_id', 'sales', 'id', ['constraint' => 'attribute_links_ibfk_5'])
            ->save();
        
        $sql = "grant select, insert, update on attribute_links to vikuraa_users";
        $this->execute($sql);
    }

    public function down(): void
    {
        $this->execute('DROP TABLE attribute_links');
    }
}
