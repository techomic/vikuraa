<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateViewItemsWithSuppliersAndInventory extends AbstractMigration
{
    public function up(): void
    {
        $this->execute("create or replace view items_with_suppliers_and_inventory as
            select
                i.id,
                i.name,
                i.category,
                i.supplier_id,
                s.company_name as supplier_company_name,
                s.agency_name as supplier_agency_name,
                s.account_number as supplier_account_number,
                s.tax_id as supplier_tax_id,
                s.deleted as supplier_deleted,
                s.category as supplier_category,
                i.item_number,
                i.description,
                i.cost_price,
                i.unit_price,
                i.reorder_level,
                i.receiving_quantity,
                i.pic_filename,
                i.allow_alt_description,
                i.is_serialized,
                i.stock_type,
                i.item_type,
                i.deleted,
                i.tax_category_id,
                i.qty_per_pack,
                i.pack_name,
                i.low_sell_item_id,
                i.hsn_code,
                inv.id as inventory_id,
                inv.user as inventory_user,
                inv.date as inventory_date,
                inv.comment as inventory_comment,
                inv.location as inventory_location,
                inv.inventory
            from items as i
            left join suppliers s on i.supplier_id = s.person_id
            right join inventory inv on inv.items = i.id");
        
        $sql = "grant select on items_with_suppliers_and_inventory to vikuraa_users";
        $this->execute($sql);
    }

    public function down(): void
    {
        $this->execute("DROP VIEW items_with_suppliers_and_inventory");
    }
}
