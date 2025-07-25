<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class ChangeGiftCardNumberToInt extends AbstractMigration
{
    public function change(): void
    {
        $sql = "alter table public.giftcards drop column giftcard_number; alter table giftcards add column num int4 null;";

        $this->execute($sql);
    }
}
