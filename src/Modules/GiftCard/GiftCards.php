<?php

namespace Vikuraa\Modules\GiftCard;

use Vikuraa\Core\Collection;

class GiftCards extends Collection
{
    public function __construct()
    {
        parent::__construct(GiftCard::class);
    }

    public function addAll(array $items) : void
    {
        foreach ($items as $card) {
            $this->add($card);
        }
    }

    public function addFromDbArray(array $row) : void
    {
        $this->add(GiftCard::fromDbArray($row));
    }

    public function addAllFromDbArray(array $data) : void
    {
        foreach ($data as $row) {
            $this->addFromDbArray($row);
        }
    }
}