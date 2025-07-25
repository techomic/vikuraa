<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTableTaxJurisdictions extends AbstractMigration
{
    public function up(): void
    {
        $table = $this->table('tax_jurisdictions')
            ->addColumn('jurisdiction_name', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('tax_group', 'string', ['limit' => 32])
            ->addColumn('tax_type', 'smallinteger', ['limit' => 2])
            ->addColumn('reporting_authority', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('tax_group_sequence', 'smallinteger', ['limit' => 1, 'default' => 0])
            ->addColumn('cascade_sequence', 'smallinteger', ['limit' => 1, 'default' => 0])
            ->addColumn('deleted', 'boolean', ['null' => false, 'default' => false])
            ->create();
        
        $sql = "grant select, insert, update on tax_jurisdictions to vikuraa_users";
        $this->execute($sql);
    }

    public function down(): void
    {
        $this->table('tax_jurisdictions')->drop()->save();
    }
}
