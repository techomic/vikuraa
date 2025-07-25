<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTableExpenses extends AbstractMigration
{
    public function up(): void
    {
        $this->table('expenses')
            ->addColumn('date', 'timestamp', ['null' => true, 'default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('amount', 'decimal', ['precision' => 15, 'scale' => 2, 'null' => false])
            ->addColumn('payment_type', 'string', ['limit' => 40, 'null' => false])
            ->addColumn('expense_category_id', 'integer', ['null' => false])
            ->addColumn('description', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('employee_id', 'integer', ['null' => false])
            ->addColumn('deleted', 'boolean', ['null' => false, 'default' => false])
            ->addColumn('supplier_tax_code', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('tax_amount', 'decimal', ['precision' => 15, 'scale' => 2, 'null' => true])
            ->addColumn('supplier_id', 'integer', ['null' => true])
            ->addIndex('expense_category_id', ['name' => 'expenses_expense_category_id'])
            ->addIndex('employee_id', ['name' => 'expenses_employee_id'])
            ->addIndex('supplier_id', ['name' => 'expenses_supplier_id'])
            ->addIndex('date', ['name' => 'expenses_date'])
            ->addIndex('payment_type', ['name' => 'expenses_payment_type'])
            ->addIndex('amount', ['name' => 'expenses_amount'])
            ->addForeignKey('expense_category_id', 'expense_categories', 'id', ['delete' => 'RESTRICT', 'update' => 'CASCADE', 'constraint' => 'expenses_ibfk_1'])
            ->addForeignKey('employee_id', 'employees', 'person_id', ['delete' => 'RESTRICT', 'update' => 'CASCADE', 'constraint' => 'expenses_ibfk_2'])
            ->addForeignKey('supplier_id', 'suppliers', 'person_id', ['delete' => 'RESTRICT', 'update' => 'CASCADE', 'constraint' => 'vikuraa_expenses_ibfk_3'])
            ->save();

        $this->execute('GRANT SELECT, INSERT, UPDATE ON expenses TO vikuraa_users');
    }

    public function down(): void
    {
        $this->table('expenses')->drop()->save();
    }
}
