<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTableAttributeDefinitions extends AbstractMigration
{
    public function up(): void
    {
        $this->table('attribute_definitions')
            // ->addColumn('id', 'integer', ['identity' => true])
            ->addColumn('name', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('type', 'string', ['limit' => 45, 'null' => false])
            ->addColumn('unit', 'string', ['limit' => 16, 'null' => true])
            ->addColumn('flags', 'smallinteger', ['null' => false])
            ->addColumn('fk', 'integer', ['null' => true])
            ->addColumn('deleted', 'boolean', ['null' => false, 'default' => 0])
            ->addIndex(['fk'], ['name' => 'attribute_definitions_fk'])
            ->addIndex(['name'], ['name' => 'attribute_definitions_name'])
            ->addIndex(['type'], ['name' => 'attribute_definitions_type'])
            ->addForeignKey('fk', 'attribute_definitions', 'id', ['delete' => 'SET_NULL', 'update' => 'CASCADE'])
            ->save();
        
            $sql = "grant select, insert, update on attribute_definitions to vikuraa_users";
            $this->execute($sql);
    }

    public function down(): void
    {
        $this->table('attribute_definitions')->drop()->save();
    }
}
