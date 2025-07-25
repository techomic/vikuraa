<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateViewSupplierPerson extends AbstractMigration
{
    public function up(): void
    {
        $this->execute("
            create or replace view suppliers_people as
            select
                s.person_id,
                s.company_name,
                s.agency_name,
                s.account_number,
                s.tax_id,
                s.deleted,
                s.category,
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
                p.created_at
            from suppliers s
            left join people p on s.person_id = p.person_id
        ");
        
        $sql = "grant select on suppliers_people to vikuraa_users";
        $this->execute($sql);
    }

    public function down(): void
    {
        $this->execute("DROP VIEW suppliers_people");
    }
}
