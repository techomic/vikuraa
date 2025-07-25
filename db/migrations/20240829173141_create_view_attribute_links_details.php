<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateViewAttributeLinksDetails extends AbstractMigration
{
    public function up(): void
    {
        $this->execute("create view attribute_links_details as
            select
                al.attribute_id,
                av.value as attribute_value_value,
                av.\"date\" as attribute_value_date,
                av.\"decimal\" as attribute_value_decimal,
                al.definition_id,
                ad.\"name\" as attribute_definition_name,
                ad.\"type\" as attribute_definition_type,
                ad.unit as attribute_definition_unit,
                ad.flags as attribute_definition_flags,
                ad.fk as attribute_definition_parent_id,
                ad.deleted as attribute_definition_deleted,
                al.item_id,
                i.\"name\" as item_name,
                i.category as item_category,
                i.supplier_id as item_supplier_id,
                i.item_number as item_number,
                i.description as item_description,
                i.cost_price as item_cost_price,
                i.unit_price as item_unit_price,
                i.reorder_level as item_reorder_level,
                i.receiving_quantity as item_receiving_quantity,
                i.pic_filename as item_pic_filename,
                i.allow_alt_description as item_allow_all_description,
                i.is_serialized as item_is_serialized,
                i.stock_type as item_stock_type,
                i.item_type as item_type,
                i.deleted as item_deleted,
                i.tax_category_id as item_tax_category_id,
                i.qty_per_pack as item_quantity_per_pack,
                i.pack_name as item_pack_name,
                i.low_sell_item_id as item_low_sell_item_id,
                i.hsn_code as item_hsn_code,
                al.sale_id,
                s.sale_time,
                s.customer_id as sale_customer_id,
                s.employee_id as sale_employee_id,
                s.\"comment\" as sale_comment,
                s.invoice_number as sale_invoice_number,
                s.quote_number as sale_quote_number,
                s.sale_status,
                s.dinner_table_id as sale_dinner_table_id,
                s.work_order_number as sale_work_order_number,
                al.receiving_id,
                r.receiving_time,
                r.supplier_id as receiving_supplier_id,
                r.employee_id as receiving_employee_id,
                r.\"comment\" as receiving_comment,
                r.payment_type as receiving_payment_type,
                r.reference as receiving_reference
            from attribute_links al 
            left join attribute_values av on al.attribute_id = av.id
            left join attribute_definitions ad on al.definition_id = ad.id
            left join items i on al.item_id = i.id
            left join sales s on al.sale_id = s.id
            left join receivings r on al.receiving_id = r.id");
        
        $sql = "grant select on attribute_links_details to vikuraa_users";
        $this->execute($sql);
    }

    public function down(): void
    {
        $this->execute("DROP VIEW attribute_links_details");
    }
}
