<?php

namespace Vikuraa\Modules\Cashup;

use Vikuraa\Core\Collection;

class Cashups extends Collection
{
    public function __construct()
    {
        parent::__construct(Cashup::class);
    }

    // add array of objects
    public function addAll(array $items) : void
    {
        foreach ($items as $cashup) {
            $this->add($cashup);
        }
    }

    // add one row from db
    public function addFromDbArray(array $row) : void
    {
        $this->add(Cashup::fromDbArray($row));
    }

    // add multiple rows from db
    public function addAllFromDbArray(array $data) : void
    {
        foreach ($data as $row) {
            $this->addFromDbArray($row);
        }
    }
}