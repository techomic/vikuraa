<?php

namespace Vikuraa\Modules\GiftCard;

use Symfony\Component\Config\Definition\Builder\NodeBuilder;
use Vikuraa\Core\Model;
use Vikuraa\Exceptions\NoDataException;

class GiftCardModel extends Model
{
    public function exists(int $id) : bool
    {
        $sql = "select * from giftcards where deleted = false and id = ?";

        return $this->db->count($sql, [$id]) > 0;
    }

    public function getMaxNumber() : int
    {
        $sql = "select max(num) as max_number from giftcards where deleted = false";

        $data = $this->db->query($sql);

        return $data[0]['max_number'];
    }

    public function total() : int
    {
        $sql = "select * from giftcards where deleted = false";

        return $this->db->count($sql);
    }

    public function byId(int $id) : GiftCard
    {
        $sql = "select * from giftcards where deleted = false and id = ?";

        $data = $this->db->query($sql, [$id]);

        if (empty($data)) {
            throw new NoDataException('Gift card not found');
        }

        return GiftCard::fromDbArray($data[0]);
    }

    public function byNumber(int $number) : GiftCard
    {
        $sql = "select * from giftcards where deleted = false and num = ?";

        $data = $this->db->query($sql, [$number]);

        if (empty($data)) {
            throw new NoDataException('Gift card not found');
        }

        return GiftCard::fromDbArray($data[0]);
    }

    public function byIds(array $ids) : GiftCards
    {
        $placeHolder = implode(', ', array_fill(0, count($ids), '?'));

        $sql = "select * from giftcards where deleted = false and id in ({$placeHolder})";

        $data = $this->db->query($sql, $ids);

        if (empty($data)) {
            throw new NoDataException('Giftcards not found');
        }

        $giftCards = new GiftCards;

        $giftCards->addAllFromDbArray($data);

        return $giftCards;
    }

    public function save(GiftCard $card) : int|false
    {
        $args = [
            'val' => $card->value,
            'person_id' => $card->personId,
            'num' => $card->number,
        ];

        if (empty($card->id)) {
            $sql = "
                insert into giftcards
                (value, person_id, num)
                values
                (:val, :person_id, :num)
            ";
        } else {
            $sql = "
                update giftcards set
                    value = :val,
                    person_id = :person_id,
                    num = :num,
                    deleted = :deleted
                where id = :id
            ";
            $args['id'] = $card->id;
            $args['deleted'] = $card->deleted;
        }

        return $this->db->execute($sql, $args, true);
    }

    public function delete(int $id) : bool
    {
        $sql = "update giftcards set deleted = true where id = ?";

        return $this->db->execute($sql, [$id]);
    }

    public function search(string $query, int $limit = 0, int $offset = 0) : GiftCards
    {
        $sql = "
            select *
            from giftcard_person
            where
                (
                    id = cast(:query as int4)
                    or value = cast(:query as numeric)
                    or num = cast(:query as int4)
                    or person_first_name || ' ' || person_last_name ilike cast(:query as text)
                    or person_phone_number ilike cast(:query as text)
                    or person_email ilike cast(:query as text)
                    or person_address_1 ilike cast(:query as text)
                    or person_address_2 ilike cast(:query as text)
                    or person_city ilike cast(:query as text)
                    or person_state ilike cast(:query as text)
                    or person_zip ilike cast(:query as text)
                    or person_country ilike cast(:query as text)
                    or person_comments ilike cast(:query as text)
                ) and deleted = false
        ";
        $args = ['query' => $query];

        if ($limit > 0) {
            $sql .= " limit cast(:limit as int) ";
            $args['limit'] = $limit;
        }
        
        if ($offset > 0) {
            $sql .= " offset cast(:offset as int) ";
            $args['offset'] = $offset;
        }

        $data = $this->db->query($sql, $args);

        if (empty($data)) {
            throw new NoDataException('Gift card not found');
        }

        $cards = new GiftCards;
        foreach ($data as $row) {
            $card = GiftCard::fromDbArray($row);
            $card->setPersonFromDbArray($row);
            $cards->add($card);
        }

        return $cards;
    }
}