<?php

namespace Vikuraa\Modules\People;

use Vikuraa\Core\Model;
use Vikuraa\Exceptions\NoDataException;

class PersonModel extends Model
{
    public function save(Person $person)
    {
        $sql = "
            insert into people (
                first_name,
                last_name,
                gender,
                phone_number,
                email,
                address_1,
                address_2,
                city,
                state,
                zip,
                country,
                comments
            ) values (
                :first_name,
                :last_name,
                :gender,
                :phone_number,
                :email,
                :address_1,
                :address_2,
                :city,
                :state,
                :zip,
                :country,
                :comments
            ) 
        ";

        $args = [
            'first_name' => $person->firstName,
            'last_name' => $person->lastName,
            'gender' => $person->gender,
            'phone_number' => $person->phoneNumber,
            'email' => $person->email,
            'address_1' => $person->address1,
            'address_2' => $person->address2,
            'city' => $person->city,
            'state' => $person->state,
            'zip' => $person->zip,
            'country' => $person->country,
            'comments' => $person->comments,
        ];

        return $this->db->execute($sql, $args, true);
    }

    public function emailExists(string $email): bool
    {
        $sql = "select * from people where email = :email";
        $args = ['email' => $email];
        return $this->db->count($sql, $args) > 0;
    }

    public function exists(int $id) : bool
    {
        $sql = "select * from public.people where person_id = ?";

        return $this->db->count($sql, [$id]) > 0;
    }

    public function all($limit = 0, $offset = 0) : Persons
    {
        $sql = "select * from public.people";

        $data = [];

        if ($limit > 0 || $offset > 0) {
            $args = [];
            if ($limit > 0) {
                $sql .= " limit cast(:limit as int) ";
                $args['limit'] = $limit;
            }
    
            if ($offset > 0) {
                $sql .= " offset cast(:offset as int) ";
                $args['offset'] = $offset;
            }

            $data = $this->db->query($sql, $args);
        } else {
            $data = $this->db->query($sql);
        }

        if (empty($data)) {
            throw new NoDataException('No persons found');
        }

        $people = new Persons;
        $people->addAllFromDbArray($data);
        return $people;
    }

    public function total() : int
    {
        $sql = "select * from public.people";

        return $this->db->count($sql);
    }

    public function byId(int $id) : Person
    {
        $sql = "select * from public.people where person_id = ?";

        $data = $this->db->query($sql, [$id]);

        if (empty($data)) {
            throw new NoDataException('Person not found');
        }

        return Person::fromDbArray($data[0]);
    }

    public function byIds(array $ids) : Persons
    {
        $placeHolder = implode(', ', array_fill(0, count($ids), '?'));

        $sql = "select * from public.people where person_id in ({$placeHolder})";

        $data = $this->db->query($sql, $ids);

        if (empty($data)) {
            throw new NoDataException('No people found');
        }

        $people = new Persons;
        $people->addAllFromDbArray($data);
        return $people;
    }
}