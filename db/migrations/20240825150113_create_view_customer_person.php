<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateViewCustomerPerson extends AbstractMigration
{
    public function up(): void
    {
        $view = $this->execute("create view customer_person as
            select
                p.*,
                company_name,
                account_number,
                taxable,
                tax_id,
                sales_tax_code_id,
                discount,
                discount_type,
                package_id,
                points,
                deleted,
                date,
                employee_id,
                consent
            from customers c
            left join people p on c.person_id = p.person_id");
        
        $sql = "grant select on customer_person to vikuraa_users";
        $this->execute($sql);
    }

    public function down(): void
    {
        $this->execute("DROP VIEW customer_person");
    }
}
