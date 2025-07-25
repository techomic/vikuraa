<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTableCustomerPoints extends AbstractMigration
{
    public function up(): void
    {
        $this->table('customer_points')
            ->addColumn('person_id', 'integer', ['null' => false])
            ->addColumn('package_id', 'integer', ['null' => false])
            ->addColumn('sale_id', 'integer', ['null' => false])
            ->addColumn('points_earned', 'integer', ['null' => false])
            ->addIndex('person_id', ['name' => 'customer_points_person_id'])
            ->addIndex('package_id', ['name' => 'customer_points_package_id'])
            ->addIndex('sale_id', ['name' => 'customer_points_sale_id'])
            ->addForeignKey('person_id', 'customers', 'person_id', ['delete' => 'RESTRICT', 'update' => 'CASCADE', 'constraint' => 'fk_customer_points_person_id'])
            ->addForeignKey('package_id', 'customer_packages', 'id', ['delete' => 'RESTRICT', 'update' => 'CASCADE', 'constraint' => 'fk_customer_points_package_id'])
            ->addForeignKey('sale_id', 'sales', 'id', ['delete' => 'RESTRICT', 'update' => 'CASCADE', 'constraint' => 'fk_customer_points_sale_id'])
            ->save();
        
        $sql = "grant select, insert, update on customer_points to vikuraa_users";
        $this->execute($sql);
    }

    public function down(): void
    {
        $this->table('customer_points')->drop()->save();
    }
}
