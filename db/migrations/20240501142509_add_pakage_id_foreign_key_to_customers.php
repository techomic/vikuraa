<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddPakageIdForeignKeyToCustomers extends AbstractMigration
{
    public function change(): void
    {
        $this->table('customers')
            ->addForeignKey('package_id', 'customer_packages', 'id', ['delete' => 'RESTRICT', 'update' => 'CASCADE', 'constraint' => 'fk_customer_package_id'])
            ->save();
    }
}
