<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTableGiftcards extends AbstractMigration
{
    public function up(): void
    {
        $this->table('giftcards')
            ->addColumn('record_time', 'timestamp', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('giftcard_number', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('value', 'decimal', ['precision' => 15, 'scale' => 2, 'null' => false])
            ->addColumn('deleted', 'boolean', ['null' => false, 'default' => false])
            ->addColumn('person_id', 'integer', ['limit' => 10, 'null' => true])
            ->addIndex('giftcard_number', ['unique' => true, 'name' => 'giftcards_giftcard_number'])
            ->addIndex('person_id')
            ->addForeignKey('person_id', 'people', 'person_id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION', 'constraint' => 'fk_giftcards_person_id'])
            ->save();
        
        $sql = "grant select, insert, update on giftcards to vikuraa_users";
        $this->execute($sql);
    }

    public function down(): void
    {
        $this->table('giftcards')->drop()->save();
    }
}
