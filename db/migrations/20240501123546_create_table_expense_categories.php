<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTableExpenseCategories extends AbstractMigration
{
    public function up(): void
    {
        $this->table('expense_categories')
            ->addColumn('category_name', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('category_description', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('deleted', 'boolean', ['default' => false, 'null' => false])
            ->addIndex('category_name', ['name' => 'expense_categories_category_name', 'unique' => true])
            ->addIndex('category_description', ['name' => 'expense_categories_category_description'])
            ->save();

        $sql = "grant select, insert, update on expense_categories to vikuraa_users";
        $this->execute($sql);
    }

    public function down(): void
    {
        $this->table('expense_categories')->drop()->save();
    }
}
