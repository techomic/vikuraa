<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateViewGiftCardPerson extends AbstractMigration
{
    public function up(): void
    {
        $sql = "
            create or replace view public.giftcard_person as
                select
                    g.id,
                    g.record_time,
                    g.value,
                    g.deleted,
                    g.num,
                    g.person_id,
                    p.first_name as person_first_name,
                    p.last_name as person_last_name,
                    p.gender as person_gender,
                    p.phone_number as person_phone_number,
                    p.email as person_email,
                    p.address_1 as person_address_1,
                    p.address_2 as person_address_2,
                    p.city as person_city,
                    p.state as person_state,
                    p.zip as person_zip,
                    p.country as person_country,
                    p.comments as person_comments,
                    p.created_at as person_created_at
                from public.giftcards g
                left join public.people p on g.person_id = p.person_id;
            grant select on public.giftcard_person to vikuraa_users;
        ";
        $this->execute($sql);
    }

    public function down()
    {
        $sql = "drop view public.giftcard_person";
        $this->execute($sql);
    }
}
