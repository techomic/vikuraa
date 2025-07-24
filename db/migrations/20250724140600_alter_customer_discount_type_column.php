<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AlterCustomerDiscountTypeColumn extends AbstractMigration
{
    public function up(): void
    {
        $this->execute("
            drop view public.customer_person;
            alter table public.customers alter column discount_type type varchar(20) using discount_type::varchar(20);
            alter table public.customers alter column discount_type set default 'percentage_discount';
            create view public.customer_person as 
                select
                    p.person_id,
                    p.first_name,
                    p.last_name,
                    p.gender,
                    p.phone_number,
                    p.email,
                    p.address_1,
                    p.address_2,
                    p.city,
                    p.state,
                    p.zip,
                    p.country,
                    p.comments,
                    p.created_at,
                    c.company_name,
                    c.account_number,
                    c.taxable,
                    c.tax_id,
                    c.sales_tax_code_id,
                    c.discount,
                    c.discount_type,
                    c.package_id,
                    c.points,
                    c.deleted,
                    c.date,
                    c.employee_id,
                    c.consent
                from customers c
                left join people p ON c.person_id = p.person_id;

            grant select on customer_person to vikuraa_users;
        ");
    }

    public function down(): void
    {
        $this->execute("
            drop view public.customer_person;
            alter table public.customers drop column discount_type;
            alter table public.customers add column discount_type type int2;
            create view public.customer_person as 
                select
                    p.person_id,
                    p.first_name,
                    p.last_name,
                    p.gender,
                    p.phone_number,
                    p.email,
                    p.address_1,
                    p.address_2,
                    p.city,
                    p.state,
                    p.zip,
                    p.country,
                    p.comments,
                    p.created_at,
                    c.company_name,
                    c.account_number,
                    c.taxable,
                    c.tax_id,
                    c.sales_tax_code_id,
                    c.discount,
                    c.discount_type,
                    c.package_id,
                    c.points,
                    c.deleted,
                    c.date,
                    c.employee_id,
                    c.consent
                from customers c
                left join people p ON c.person_id = p.person_id;

                grant select on customer_person to vikuraa_users;
        ");
    }
}
