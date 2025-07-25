<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class InsertPermissions extends AbstractMigration
{
    public function up(): void
    {
        $table = $this->table('permissions');

        $data = [
            ['id' => 'attributes', 'module_id' => 'attributes', 'location_id' => null],
            ['id' => 'cashups', 'module_id' => 'cashups', 'location_id' => null],
            ['id' => 'config', 'module_id' => 'config', 'location_id' => null],
            ['id' => 'customers', 'module_id' => 'customers', 'location_id' => null],
            ['id' => 'employees', 'module_id' => 'employees', 'location_id' => null],
            ['id' => 'expenses', 'module_id' => 'expenses', 'location_id' => null],
            ['id' => 'expenses_categories', 'module_id' => 'expenses_categories', 'location_id' => null],
            ['id' => 'giftcards', 'module_id' => 'giftcards', 'location_id' => null],
            ['id' => 'home', 'module_id' => 'home', 'location_id' => null],
            ['id' => 'items', 'module_id' => 'items', 'location_id' => null],
            ['id' => 'items_stock', 'module_id' => 'items', 'location_id' => 1],
            ['id' => 'item_kits', 'module_id' => 'item_kits', 'location_id' => null],
            ['id' => 'messages', 'module_id' => 'messages', 'location_id' => null],
            ['id' => 'office', 'module_id' => 'office', 'location_id' => null],
            ['id' => 'receivings', 'module_id' => 'receivings', 'location_id' => null],
            ['id' => 'receivings_stock', 'module_id' => 'receivings', 'location_id' => 1],
            ['id' => 'reports', 'module_id' => 'reports', 'location_id' => null],
            ['id' => 'reports_categories', 'module_id' => 'reports', 'location_id' => null],
            ['id' => 'reports_customers', 'module_id' => 'reports', 'location_id' => null],
            ['id' => 'reports_discounts', 'module_id' => 'reports', 'location_id' => null],
            ['id' => 'reports_employees', 'module_id' => 'reports', 'location_id' => null],
            ['id' => 'reports_expenses_categories', 'module_id' => 'reports', 'location_id' => null],
            ['id' => 'reports_inventory', 'module_id' => 'reports', 'location_id' => null],
            ['id' => 'reports_items', 'module_id' => 'reports', 'location_id' => null],
            ['id' => 'reports_payments', 'module_id' => 'reports', 'location_id' => null],
            ['id' => 'reports_receivings', 'module_id' => 'reports', 'location_id' => null],
            ['id' => 'reports_sales', 'module_id' => 'reports', 'location_id' => null],
            ['id' => 'reports_sales_taxes', 'module_id' => 'reports', 'location_id' => null],
            ['id' => 'reports_suppliers', 'module_id' => 'reports', 'location_id' => null],
            ['id' => 'reports_taxes', 'module_id' => 'reports', 'location_id' => null],
            ['id' => 'sales', 'module_id' => 'sales', 'location_id' => null],
            ['id' => 'sales_change_price', 'module_id' => 'sales', 'location_id' => null],
            ['id' => 'sales_delete', 'module_id' => 'sales', 'location_id' => null],
            ['id' => 'sales_stock', 'module_id' => 'sales', 'location_id' => 1],
            ['id' => 'suppliers', 'module_id' => 'suppliers', 'location_id' => null],
            ['id' => 'taxes', 'module_id' => 'taxes', 'location_id' => null]
        ];

        $table->insert($data)->saveData();
    }

    public function down(): void
    {
        $this->execute('DELETE FROM permissions');
    }
}
