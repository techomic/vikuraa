<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTableSalePayments extends AbstractMigration
{
    public function up(): void
    {
        $this->table('sale_payments')
            ->addColumn('sale_id', 'integer', ['null' => false])
            ->addColumn('payment_type', 'string', ['limit' => 40, 'null' => false])
            ->addColumn('payment_amount', 'decimal', ['precision' => 15, 'scale' => 2, 'null' => false])
            ->addColumn('cash_refund', 'decimal', ['precision' => 15, 'scale' => 2, 'null' => false, 'default' => 0.00])
            ->addColumn('cash_adjustment', 'smallinteger', ['null' => false, 'default' => 0])
            ->addColumn('employee_id', 'integer', ['null' => true])
            ->addColumn('payment_time', 'timestamp', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('reference_code', 'string', ['limit' => 40, 'null' => false, 'default' => ''])
            ->addIndex(['sale_id', 'payment_type'], ['name' => 'sale_payments_payment_sale'])
            ->addIndex('payment_time', ['name' => 'sale_payments_payment_time'])
            ->addForeignKey('sale_id', 'sales', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE', 'constraint' => 'fk_sale_payments_sale_id'])
            ->addForeignKey('employee_id', 'employees', 'person_id', ['delete' => 'RESTRICT', 'update' => 'CASCADE', 'constraint' => 'fk_sale_payments_employee_id'])
            ->save();

        $this->execute('GRANT SELECT, INSERT, UPDATE ON sale_payments TO vikuraa_users');
    }

    public function down(): void
    {
        $this->table('sale_payments')->drop()->save();
    }
}
