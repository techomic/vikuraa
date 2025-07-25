<?php

namespace Vikuraa\Modules\GiftCard;

use Vikuraa\Core\Entity;
use DateTime;
use Vikuraa\Modules\People\Person;

class GiftCard extends Entity
{
    protected ?int $id;
    protected ?DateTime $recordTime;
    protected ?string $number;
    protected int $value;
    protected ?bool $deleted;
    protected ?int $personId;
    protected ?Person $person;

    public static function fromDbArray(array $data): static
    {
        $card = new static;
        $card->id = $data['id'];
        $card->recordTime = $data['record_time'] == null ? null : new DateTime($data['record_time']);
        $card->number = $data['num'];
        $card->value = $data['value'];
        $card->deleted = $data['deleted'];
        $card->personId = $data['personId'];
        return $card;
    }

    public function setPersonFromDbArray(array $data)
    {
        $person = Person::fromDbArray([
            'person_id'     => $data['person_id'],
            'first_name'    => $data['person_first_name'],
            'last_name'     => $data['person_last_name'],
            'gender'        => $data['person_gender'],
            'phone_number'  => $data['person_phone_number'],
            'email'         => $data['person_email'],
            'address_1'     => $data['person_address_1'],
            'address_2'     => $data['person_address_2'],
            'city'          => $data['person_city'],
            'state'         => $data['person_state'],
            'zip'           => $data['person_zip'],
            'country'       => $data['person_country'],
            'comments'      => $data['person_comments'],
            'created_at'    => $data['person_created_at'],
        ]);
        $this->person = $person;
    }
}