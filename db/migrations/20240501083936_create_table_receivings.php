<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTableReceivings extends AbstractMigration
{
    // TODO: add foreign key to supplier_id
    // TODO: add foreign key to employee_id
    public function up(): void
    {
        $this->table('receivings')
            ->addColumn('receiving_time', 'timestamp', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('supplier_id', 'integer')
            ->addColumn('employee_id', 'integer', ['null' => false, 'default' => 0])
            ->addColumn('comment', 'text')
            ->addColumn('payment_type', 'string', ['limit' => 20])
            ->addColumn('reference', 'string', ['limit' => 32])
            ->addIndex(['supplier_id'], ['name' => 'receivings_supplier_id'])
            ->addIndex(['employee_id'], ['name' => 'receivings_employee_id'])
            ->addIndex(['reference'], ['name' => 'receivings_reference'])
            ->addIndex(['receiving_time'], ['name' => 'receivings_receiving_time'])
            ->save();
        
        $sql = "grant select, insert, update, delete on receivings to vikuraa_users";
        $this->execute($sql);
    }

    public function down(): void
    {
        $this->table('receivings')->drop()->save();
    }
}
