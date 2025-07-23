<?php

namespace Vikuraa\Modules\Cashup;

use Vikuraa\Core\Model;
use Vikuraa\Exceptions\NoDataException;

class CashupModel extends Model
{
    /**
     * Checks if the cashup of a certain id exists or not.
     * 
     * @param int $id the id of the cashup
     */
    public function exists(int $id) : bool
    {
        $sql = "select * from cash_up where id = ? and deleted = false";

        return $this->db->count($sql, [$id]) > 0;
    }

    /**
     * Get cash up by id
     * 
     * @todo create a view to get employee info along with cash up info and use the view in the query
     * @param int $id cashup id
     */
    public function byId(int $id) : Cashup
    {
        $sql = "select * from cash_up where id = ? and deleted = false";

        $data = $this->db->query($sql, [$id]);

        if (empty($data)) {
            throw new NoDataException('Cashup not found');
        }

        return Cashup::fromDbArray($data[0]);
    }

    /**
     * Get multiple cashups by an array of ids
     * 
     * @todo create a view to get employee info along with cash up info
     * @param array array of cash up ids
     */
    public function byIds(array $ids) : Cashups
    {
        $placeHolders = implode(', ', array_fill(0, count($ids), '?'));

        $sql = "select * from cash_up where id in ({$placeHolders}) and deleted = false";

        $data = $this->db->query($sql, $ids);

        if (empty($data)) {
            throw new NoDataException('Cashups not found');
        }

        $cashups = new Cashups();
        $cashups->addAllFromDbArray($data);
        return $cashups;
    }

    /**
     * @todo search from the above mentioned view
     */
    public function search(string $query, array $filters)
    {
        $sql = "
            SELECT
                cash_up.id,
                MAX(cash_up.open_date) AS open_date,
                MAX(cash_up.close_date) AS close_date,
                MAX(cash_up.open_amount_cash) AS open_amount_cash,
                MAX(cash_up.transfer_amount_cash) AS transfer_amount_cash,
                MAX(cash_up.closed_amount_cash) AS closed_amount_cash,
                MAX(cash_up.closed_amount_due) AS closed_amount_due,
                MAX(cash_up.closed_amount_card) AS closed_amount_card,
                MAX(cash_up.closed_amount_check) AS closed_amount_check,
                MAX(cash_up.closed_amount_total) AS closed_amount_total,
                MAX(cash_up.description) AS description,
                MAX(cash_up.note) AS note,
                MAX(cash_up.open_employee_id) AS open_employee_id,
                MAX(cash_up.close_employee_id) AS close_employee_id,
                MAX(open_employees.first_name) AS open_first_name,
                MAX(open_employees.last_name) AS open_last_name,
                MAX(close_employees.first_name) AS close_first_name,
                MAX(close_employees.last_name) AS close_last_name
            FROM cash_up AS cash_up
            LEFT JOIN people AS open_employees ON open_employees.person_id = cash_up.open_employee_id
            LEFT JOIN people AS close_employees ON close_employees.person_id = cash_up.close_employee_id
            WHERE
                (
                    cash_up.open_date::text ILIKE :q OR
                    open_employees.first_name ILIKE :q OR
                    open_employees.last_name ILIKE :q OR
                    close_employees.first_name ILIKE :q OR
                    close_employees.last_name ILIKE :q OR
                    cash_up.closed_amount_total::text ILIKE :q OR
                    (open_employees.first_name || ' ' || open_employees.last_name) ILIKE :q OR
                    (close_employees.first_name || ' ' || close_employees.last_name) ILIKE :q
                )
                AND cash_up.deleted = :is_deleted
                AND (";
        $format = $this->config->getValue('date_or_time_format');
        if (empty($format)) {
            $sql .= "TO_CHAR(cash_up.open_date, 'YYYY-MM-DD') BETWEEN :start_date AND :end_date";
        } else {
            $sql .= "to_char(cash_up.open_date, '{$format}') between :start_date and :end_date";
        }
        $sql .= "
                )
            GROUP BY cash_up.id;
        ";

        $args = [
            'q' => $query,
            'is_deleted' => $filters['deleted'],
            'start_date' => $filters['start_date'],
            'end_date' => $filters['end_date']
        ];

        $data = $this->db->query($sql, $args);

        if (empty($data)) {
            throw new NoDataException('Cashups not found');
        }

        return $data;
    }

    public function deleteMultiple(array $ids) : bool
    {
        $placeHolders = implode(',', array_fill(0, count($ids), '?'));

        $sql = "update cash_up set deleted = true where id in ({$placeHolders})";

        return $this->db->execute($sql, $ids);
    }

    /**
     * @todo complete this method
     */
    public function save(Cashup $cashup) : bool
    {
        if (empty($cashup->id)) {
            $sql = "insert into cash_up () values ()";
        } else {
            $sql = "update cash_up set ";
        }

        return $this->db->execute($sql, $cashup->toArray());
    }
}