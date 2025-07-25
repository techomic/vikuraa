<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddModuleForeignKeyToPermissions extends AbstractMigration
{
    public function change(): void
    {
        $this->table('permissions')
            ->addForeignKey('module_id', 'modules', 'id', ['constraint' => 'fk_permissions_module_id', 'delete' => 'CASCADE', 'update' => 'CASCADE'])
            ->save();
    }
}
