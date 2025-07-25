<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTableSuppliers extends AbstractMigration
{
    /*
    CREATE TABLE `vikuraa_suppliers` (
        `person_id` int(10) NOT NULL,
        `company_name` varchar(255) NOT NULL,
        `agency_name` varchar(255) NOT NULL,
        `account_number` varchar(255) DEFAULT NULL,
        `tax_id` varchar(32) NOT NULL DEFAULT '',
        `deleted` tinyint(1) NOT NULL DEFAULT 0,
        `category` tinyint(1) NOT NULL,
        PRIMARY KEY (`person_id`),
        UNIQUE KEY `account_number` (`account_number`),
        KEY `person_id` (`person_id`),
        KEY `category` (`category`),
        KEY `company_name` (`company_name`,`deleted`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
    */
    // TODO: add tax_id foreign key
    public function up(): void
    {
        $this->table('suppliers', ['id' => false, 'primary_key' => 'person_id'])
            ->addColumn('person_id', 'integer', ['null' => false])
            ->addColumn('company_name', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('agency_name', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('account_number', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('tax_id', 'string', ['limit' => 32, 'default' => ''])
            ->addColumn('deleted', 'boolean', ['default' => false])
            ->addColumn('category', 'smallinteger', ['null' => false])
            ->addIndex('account_number', ['name' => 'suppliers_account_number', 'unique' => true])
            ->addIndex('person_id', ['name' => 'suppliers_person_id'])
            ->addIndex('category', ['name' => 'suppliers_category'])
            ->addIndex(['company_name', 'deleted'], ['name' => 'suppliers_company_name_deleted'])
            ->addForeignKey('person_id', 'people', 'person_id', ['constraint' => 'fk_suppliers_person_id', 'delete' => 'RESTRICT', 'update' => 'RESTRICT'])
            ->save();
        
        $sql = "grant select, insert, update on suppliers to vikuraa_users";
        $this->execute($sql);
    }

    public function down(): void
    {
        $this->table('suppliers')->drop()->save();
    }
}
