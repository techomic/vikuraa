<?php

namespace Vikuraa\Modules\People;

use DateTime;
use Vikuraa\Core\Entity;

class Person extends Entity
{
    protected ?int $personId;
    protected string $firstName;
    protected string $lastName;
    protected ?string $gender;
    protected string $phoneNumber;
    protected string $email;
    protected string $address1;
    protected string $address2;
    protected string $city;
    protected string $state;
    protected string $zip;
    protected string $country;
    protected string $comments;
    protected DateTime $createdAt;

    

    public static function fromDbArray(array $data): static
    {
        $person = new static();
        $person->personId = $data['person_id'];
        $person->firstName = $data['first_name'];
        $person->lastName = $data['last_name'];
        $person->gender = $data['gender'];
        $person->phoneNumber = $data['phone_number'];
        $person->email = $data['email'];
        $person->address1 = $data['address_1'];
        $person->address2 = $data['address_2'];
        $person->city = $data['city'];
        $person->state = $data['state'];
        $person->zip = $data['zip'];
        $person->country = $data['country'];
        $person->comments = $data['comments'];
        $person->createdAt = new DateTime($data['created_at']);
        return $person;
    }
}
