<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTableModules extends AbstractMigration
{
    public function up(): void
    {
        $this->table('modules', ['id' => false, 'primary_key' => 'id'])
            ->addColumn('id', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('name_lang_key', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('desc_lang_key', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('sort', 'integer', ['limit' => 10, 'null' => false])
            ->addIndex('desc_lang_key', ['name' => 'module_desc_lang_key', 'unique' => true])
            ->addIndex('name_lang_key', ['name' => 'module_name_lang_key', 'unique' => true])
            ->save();

        $sql = "grant select, insert, update on modules to vikuraa_users";
        $this->execute($sql);
    }

    public function down(): void
    {
        $this->table('modules')->drop()->save();
    }
}
