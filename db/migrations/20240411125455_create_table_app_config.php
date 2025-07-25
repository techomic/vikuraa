<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTableAppConfig extends AbstractMigration
{
    
    public function up(): void
    {
        $table = $this->table('app_config', ['id' => false, 'primary_key' => 'key']);
        $table->addColumn('key', 'string', ['limit' => 50])
            ->addColumn('value', 'string', ['limit' => 500, 'null' => false])
            ->create();

        $sql = "grant select, insert, update on app_config to vikuraa_users";
        $this->execute($sql);
    }

    public function down(): void
    {
        $this->table('app_config')->drop()->save();
    }
}
