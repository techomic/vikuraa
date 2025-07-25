<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTableGrants extends AbstractMigration
{
    public function up(): void
    {
        $this->table('grants', ['id' => false, 'primary_key' => ['permission_id', 'person_id']])
            ->addColumn('permission_id', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('person_id', 'integer', ['limit' => 10, 'null' => false])
            ->addColumn('menu_group', 'string', ['limit' => 32, 'default' => 'home'])
            ->create();

        $sql = "grant select, insert, update on grants to vikuraa_users";
        $this->execute($sql);
    }

    public function down(): void
    {
        $this->table('grants')->drop()->save();
    }
}
