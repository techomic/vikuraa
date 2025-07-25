<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class InsertModules extends AbstractMigration
{
    public function up(): void
    {
        $data = [
            [
                'name_lang_key' => 'module_attributes',
                'desc_lang_key' => 'module_attributes_desc',
                'sort' => 107,
                'id' => 'attributes'
            ],
            [
                'name_lang_key' => 'module_cashups',
                'desc_lang_key' => 'module_cashups_desc',
                'sort' => 110,
                'id' => 'cashups'
            ],
            [
                'name_lang_key' => 'module_config',
                'desc_lang_key' => 'module_config_desc',
                'sort' => 900,
                'id' => 'config'
            ],
            [
                'name_lang_key' => 'module_customers',
                'desc_lang_key' => 'module_customers_desc',
                'sort' => 10,
                'id' => 'customers'
            ],
            [
                'name_lang_key' => 'module_employees',
                'desc_lang_key' => 'module_employees_desc',
                'sort' => 80,
                'id' => 'employees'
            ],
            [
                'name_lang_key' => 'module_expenses',
                'desc_lang_key' => 'module_expenses_desc',
                'sort' => 108,
                'id' => 'expenses'
            ],
            [
                'name_lang_key' => 'module_expenses_categories',
                'desc_lang_key' => 'module_expenses_categories_desc',
                'sort' => 109,
                'id' => 'expenses_categories'
            ],
            [
                'name_lang_key' => 'module_giftcards',
                'desc_lang_key' => 'module_giftcards_desc',
                'sort' => 90,
                'id' => 'giftcards'
            ],
            [
                'name_lang_key' => 'module_home',
                'desc_lang_key' => 'module_home_desc',
                'sort' => 1,
                'id' => 'home'
            ],
            [
                'name_lang_key' => 'module_items',
                'desc_lang_key' => 'module_items_desc',
                'sort' => 20,
                'id' => 'items'
            ],
            [
                'name_lang_key' => 'module_item_kits',
                'desc_lang_key' => 'module_item_kits_desc',
                'sort' => 30,
                'id' => 'item_kits'
            ],
            [
                'name_lang_key' => 'module_messages',
                'desc_lang_key' => 'module_messages_desc',
                'sort' => 98,
                'id' => 'messages'
            ],
            [
                'name_lang_key' => 'module_office',
                'desc_lang_key' => 'module_office_desc',
                'sort' => 999,
                'id' => 'office'
            ],
            [
                'name_lang_key' => 'module_receivings',
                'desc_lang_key' => 'module_receivings_desc',
                'sort' => 60,
                'id' => 'receivings'
            ],
            [
                'name_lang_key' => 'module_reports',
                'desc_lang_key' => 'module_reports_desc',
                'sort' => 50,
                'id' => 'reports'
            ],
            [
                'name_lang_key' => 'module_sales',
                'desc_lang_key' => 'module_sales_desc',
                'sort' => 70,
                'id' => 'sales'
            ],
            [
                'name_lang_key' => 'module_suppliers',
                'desc_lang_key' => 'module_suppliers_desc',
                'sort' => 40,
                'id' => 'suppliers'
            ],
            [
                'name_lang_key' => 'module_taxes',
                'desc_lang_key' => 'module_taxes_desc',
                'sort' => 105,
                'id' => 'taxes'
            ],
        ];

        $this->table('modules')->insert($data)->saveData();
    }

    public function down(): void
    {
        $this->execute('DELETE FROM modules');
    }
}
