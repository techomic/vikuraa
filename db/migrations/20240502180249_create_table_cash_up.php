<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTableCashUp extends AbstractMigration
{
    public function up(): void
    {
        $this->table('cash_up')
            ->addColumn('open_date', 'timestamp', ['null' => true, 'default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('close_date', 'timestamp', ['null' => true, 'default' => null])
            ->addColumn('open_amount_cash', 'decimal', ['precision' => 15, 'scale' => 2, 'null' => false])
            ->addColumn('transfer_amount_cash', 'decimal', ['precision' => 15, 'scale' => 2, 'null' => false])
            ->addColumn('note', 'integer', ['limit' => 1, 'null' => false])
            ->addColumn('closed_amount_cash', 'decimal', ['precision' => 15, 'scale' => 2, 'null' => false])
            ->addColumn('closed_amount_card', 'decimal', ['precision' => 15, 'scale' => 2, 'null' => false])
            ->addColumn('closed_amount_check', 'decimal', ['precision' => 15, 'scale' => 2, 'null' => false])
            ->addColumn('closed_amount_total', 'decimal', ['precision' => 15, 'scale' => 2, 'null' => false])
            ->addColumn('description', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('open_employee_id', 'integer', ['limit' => 10, 'null' => false])
            ->addColumn('close_employee_id', 'integer', ['limit' => 10, 'null' => false])
            ->addColumn('deleted', 'boolean', ['null' => false, 'default' => false])
            ->addColumn('closed_amount_due', 'decimal', ['precision' => 15, 'scale' => 2, 'null' => false])
            ->addIndex('open_employee_id', ['name' => 'cash_up_open_employee_id'])
            ->addIndex('close_employee_id', ['name' => 'cash_up_close_employee_id'])
            ->addForeignKey('open_employee_id', 'employees', 'person_id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION', 'constraint' => 'fk_cash_up_open_employee_id'])
            ->addForeignKey('close_employee_id', 'employees', 'person_id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION', 'constraint' => 'fk_cash_up_close_employee_id'])
            ->save();
        

        $sql = "grant select, insert, update on cash_up to vikuraa_users";
        $this->execute($sql);
    }

    public function down(): void
    {
        $this->table('cash_up')->drop()->save();
    }
}
