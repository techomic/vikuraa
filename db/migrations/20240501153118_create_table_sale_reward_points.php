<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTableSaleRewardPoints extends AbstractMigration
{
    public function up(): void
    {
        $this->table('sale_reward_points')
            ->addColumn('sale_id', 'integer', ['null' => false])
            ->addColumn('earned', 'decimal', ['precision' => 15, 'scale' => 3, 'null' => false])
            ->addColumn('used', 'decimal', ['precision' => 15, 'scale' => 3, 'null' => false])
            ->addForeignKey('sale_id', 'sales', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE', 'constraint' => 'fk_sale_reward_points_sale_id'])
            ->save();

        $this->execute('GRANT SELECT, INSERT, UPDATE ON sale_reward_points TO vikuraa_users');
    }

    public function down(): void
    {
        $this->table('sale_reward_points')->drop()->save();
    }
}
