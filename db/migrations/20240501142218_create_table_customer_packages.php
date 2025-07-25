<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTableCustomerPackages extends AbstractMigration
{
    public function up(): void
    {
        $this->table('customer_packages')
            ->addColumn('package_name', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('points_percent', 'float', ['null' => false, 'default' => 0])
            ->addColumn('deleted', 'boolean', ['default' => false, 'null' => false])
            ->save();

        $sql = "grant select, insert, update on customer_packages to vikuraa_users";
        $this->execute($sql);
    }

    public function down(): void
    {
        $this->table('customer_packages')->drop()->save();
    }
}
