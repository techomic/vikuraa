<?php

namespace Vikuraa\Modules\People;

use Vikuraa\Core\Collection;

class Persons extends Collection
{
    public function __construct()
    {
        parent::__construct(Person::class);
    }

    public function addAll(array $items) : void
    {
        foreach ($items as $item) {
            $this->add($item);
        }
    }

    public function addFromDbArray(array $row) : void
    {
        $this->add(Person::fromDbArray($row));
    }

    public function addAllFromDbArray(array $data) : void
    {
        foreach ($data as $row) {
            $this->addFromDbArray($row);
        }
    }
}