<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTableCustomers extends AbstractMigration
{
    // TODO: check if taxPid is a foreign key
    public function up(): void
    {
        $this->table('customers', ['id' => false, 'primary_key' => 'person_id'])
            ->addColumn('person_id', 'integer', ['null' => false])
            ->addColumn('company_name', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('account_number', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('taxable', 'boolean', ['default' => true])
            ->addColumn('tax_id', 'string', ['limit' => 32, 'default' => ''])
            ->addColumn('sales_tax_code_id', 'integer', ['signed' => false, 'null' => true])
            ->addColumn('discount', 'decimal', ['precision' => 15, 'scale' => 2, 'default' => 0.00, 'null' => false])
            ->addColumn('discount_type', 'smallinteger', ['default' => 0, 'null' => false])
            ->addColumn('package_id', 'integer', ['signed' => false, 'null' => true])
            ->addColumn('points', 'integer', ['signed' => false, 'null' => true])
            ->addColumn('deleted', 'boolean', ['default' => false, 'null' => false])
            ->addColumn('date', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false])
            ->addColumn('employee_id', 'integer', ['signed' => false, 'null' => true])
            ->addColumn('consent', 'boolean', ['default' => false, 'null' => false])
            ->addIndex('account_number', ['unique' => true, 'name' => 'customer_account_number'])
            ->addIndex('package_id', ['name' => 'customer_package_id'])
            ->addIndex('sales_tax_code_id', ['name' => 'customer_sales_tax_code_id'])
            ->addIndex('company_name', ['name' => 'customer_company_name'])
            ->addForeignKey('sales_tax_code_id', 'tax_codes', 'id', ['delete' => 'RESTRICT', 'update' => 'CASCADE', 'constraint' => 'fk_customer_sales_tax_code_id'])
            ->addForeignKey('employee_id', 'employees', 'person_id', ['delete' => 'RESTRICT', 'update' => 'CASCADE', 'constraint' => 'fk_customer_employee_id'])
            ->save();

        $sql = "grant select, insert, update on customers to vikuraa_users";
        $this->execute($sql);
    }

    public function down(): void
    {
        $this->table('customers')->drop()->save();
    }
}
