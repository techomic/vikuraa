<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class InsertGrants extends AbstractMigration
{
    public function up(): void
    {
        $data = [
            ['permission_id' => 'attributes', 'person_id' => 1, 'menu_group' => 'office'],
            ['permission_id' => 'cashups', 'person_id' => 1, 'menu_group' => 'home'],
            ['permission_id' => 'config', 'person_id' => 1, 'menu_group' => 'office'],
            ['permission_id' => 'customers', 'person_id' => 1, 'menu_group' => 'home'],
            ['permission_id' => 'employees', 'person_id' => 1, 'menu_group' => 'office'],
            ['permission_id' => 'expenses', 'person_id' => 1, 'menu_group' => 'home'],
            ['permission_id' => 'expenses_categories', 'person_id' => 1, 'menu_group' => 'office'],
            ['permission_id' => 'giftcards', 'person_id' => 1, 'menu_group' => 'home'],
            ['permission_id' => 'home', 'person_id' => 1, 'menu_group' => 'office'],
            ['permission_id' => 'items', 'person_id' => 1, 'menu_group' => 'home'],
            ['permission_id' => 'items_stock', 'person_id' => 1, 'menu_group' => 'home'],
            ['permission_id' => 'item_kits', 'person_id' => 1, 'menu_group' => 'home'],
            ['permission_id' => 'messages', 'person_id' => 1, 'menu_group' => 'home'],
            ['permission_id' => 'office', 'person_id' => 1, 'menu_group' => 'home'],
            ['permission_id' => 'receivings', 'person_id' => 1, 'menu_group' => 'home'],
            ['permission_id' => 'receivings_stock', 'person_id' => 1, 'menu_group' => 'home'],
            ['permission_id' => 'reports', 'person_id' => 1, 'menu_group' => 'home'],
            ['permission_id' => 'reports_categories', 'person_id' => 1, 'menu_group' => 'home'],
            ['permission_id' => 'reports_customers', 'person_id' => 1, 'menu_group' => 'home'],
            ['permission_id' => 'reports_discounts', 'person_id' => 1, 'menu_group' => 'home'],
            ['permission_id' => 'reports_employees', 'person_id' => 1, 'menu_group' => 'home'],
            ['permission_id' => 'reports_expenses_categories', 'person_id' => 1, 'menu_group' => 'home'],
            ['permission_id' => 'reports_inventory', 'person_id' => 1, 'menu_group' => 'home'],
            ['permission_id' => 'reports_items', 'person_id' => 1, 'menu_group' => 'home'],
            ['permission_id' => 'reports_payments', 'person_id' => 1, 'menu_group' => 'home'],
            ['permission_id' => 'reports_receivings', 'person_id' => 1, 'menu_group' => 'home'],
            ['permission_id' => 'reports_sales', 'person_id' => 1, 'menu_group' => 'home'],
            ['permission_id' => 'reports_sales_taxes', 'person_id' => 1, 'menu_group' => 'home'],
            ['permission_id' => 'reports_suppliers', 'person_id' => 1, 'menu_group' => 'home'],
            ['permission_id' => 'reports_taxes', 'person_id' => 1, 'menu_group' => 'home'],
            ['permission_id' => 'sales', 'person_id' => 1, 'menu_group' => 'home'],
            ['permission_id' => 'sales_change_price', 'person_id' => 1, 'menu_group' => '--'],
            ['permission_id' => 'sales_delete', 'person_id' => 1, 'menu_group' => '--'],
            ['permission_id' => 'sales_stock', 'person_id' => 1, 'menu_group' => 'home'],
            ['permission_id' => 'suppliers', 'person_id' => 1, 'menu_group' => 'home'],
            ['permission_id' => 'taxes', 'person_id' => 1, 'menu_group' => 'office']
        ];

        $this->table('grants')->insert($data)->saveData();
    }

    public function down(): void
    {
        $this->execute('DELETE FROM grants');
    }
}
