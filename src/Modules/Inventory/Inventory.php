<?php

namespace Vikuraa\Modules\Inventory;

use Vikuraa\Core\Entity;
use DateTime;
use Vikuraa\Modules\Employees\Employee;

class Inventory extends Entity
{
    protected ?int $id;
    protected int $itemId;

    /**
     * @var int the employee ID
     * 
     * Assume this will be set automatically on db
     * 
     * @todo create a function on db to get id from current username
     */
    protected ?int $userId;
    protected ?DateTime $date;
    protected ?string $comment;

    /**
     * @var int id of the location
     * @todo created location classes
     */
    protected int $locationId;
    // protected ?Location $location;
    protected float $inventory;
    protected ?Employee $employee;

    public static function fromDbArray(array $data) : static
    {
        $inventory = new static;

        $inventory->id          = $data['id'];
        $inventory->itemId      = $data['items'];
        $inventory->userId      = $data['user'];
        $inventory->date        = $data['date'];
        $inventory->comment     = $data['comment'];
        $inventory->locationId  = $data['location'];
        $inventory->inventory   = $data['inventory'];

        return $inventory;
    }

    /**
     * @todo complete this method
     * @todo create view inventory_employee
     */
    public function setEmployeeFromDbArray(array $data) : void
    {
        $this->employee = Employee::fromDbArray([
            'username'      => $data[''],
            'deleted'       => $data[''],
            'hash_version'  => $data[''],
            'language'      => $data[''],
            'language_code' => $data[''],
        ]);
    }

    /**
     * @todo set location
     * @todo create view inventory_location
     */
    public function setLocationFromDbArray(array $data) : void
    {
        
    }
}