<?php

namespace Vikuraa\Modules\Suppliers;

use Vikuraa\Core\Model;
use Vikuraa\Exceptions\NoDataException;
use Vikuraa\Helpers\Functions;

class SupplierModel extends Model
{
    /**
     * Checks if a supplier exists or not.
     */
    public function exists(int $id) : bool
    {
        $sql = "select id person_id from suppliers where person_id = ? and deleted = false";
        return $this->db->count($sql, [$id]) > 0;
    }

    public function byId(int $id): Supplier
    {
        $sql = "select * from suppliers where person_id = :supplier_id and deleted = false";
        
        $args = [ 'supplier_id' => $id ];
        
        $data = $this->db->query($sql, $args);
        
        if (!(is_array($data) && count($data) > 0)) {
            throw new NoDataException('No suppliers found');
        }
        
        return Supplier::fromDbArray($data[0]);
    }

    public function total(): int
    {
        $sql = "select person_id from suppliers where deleted = false";

        return $this->db->count($sql);
    }

    public function all(int $limit = 20, int $page = 1): Suppliers
    {
        $sql = "select * from suppliers_people where deleted = false limit cast(:limit as int) offset cast(:offset as int) ";
        $args = [
            'limit' => $limit,
            'offset' => Functions::offsetFromPage($limit, $page),
        ];
        $data = $this->db->query($sql, $args);

        if (!(is_array($data) && count($data) > 0)) {
            throw new NoDataException('No suppliers found');
        }

        $suppliers = new Suppliers();
        $suppliers->addAllFromDbArray($data);
        return $suppliers;
    }

    /**
     * @todo refer to Customer::byIds and improve this method
     */
    public function byIds(array $ids): Suppliers
    {
        $sql = "select * from suppliers_people where deleted = false and person_id in (";
        $i = 0;
        $args = [];
        foreach ($ids as $id) {
            $sql .= ":id_{$i}";
            if ($i < count($ids) - 1) {
                $sql .= ",";
            }
            $args[":id_{$i}"] = $id;
            $i++;
        }
        $sql .= ")";

        $data = $this->db->query($sql, $args);
        if (!(is_array($data) && count($data) > 0)) {
            throw new NoDataException('No suppliers found');
        }

        $suppliers = new Suppliers();
        $suppliers->addAllFromDbArray($data);
        return $suppliers;

    }
    
    public function search(
        string $search,
        int $limit = 20,
        int $page = 1,
        ?string $sort = 'last_name',
        ?string $order = 'asc',
        ?bool $countOnly = false
    ): Suppliers|int
    {
        $offset = Functions::offsetFromPage($limit, $page);

        $sql = "select * from suppliers_people where deleted = false and (";
        $sql .= " lower(first_name) like concat('%', cast(:query as text), '%') ";
        $sql .= " or lower(last_name) like concat('%', cast(:query as text), '%') ";
        $sql .= " or lower(company_name) like concat('%', cast(:query as text), '%') ";
        $sql .= " or lower(agency_name) like concat('%', cast(:query as text), '%') ";
        $sql .= " or lower(email) like concat('%', cast(:query as text), '%') ";
        $sql .= " or lower(phone_number) like concat('%', cast(:query as text), '%') ";
        $sql .= " or lower(account_number) like concat('%', cast(:query as text), '%') ";
        $sql .= " or lower(concat(first_name, ' ', last_name)) like concat('%', cast(:query as text), '%') ";
        $sql .= ") order by {$sort} {$order} limit cast(:limit as int) offset cast(:offset as int) ";
        $args = [
            'query' => strtolower($search),
            'limit' => $limit,
            'offset' => $offset
        ];

        if ($countOnly) {
            return $this->db->count($sql, $args);
        }

        $data = $this->db->query($sql, $args);
        if (!(is_array($data) && count($data) > 0)) {
            throw new NoDataException('No suppliers found');
        }

        $suppliers = new Suppliers();
        $suppliers->addAllFromDbArray($data);
        return $suppliers;
    }

    /**
     * @todo implement save functionality.
     */
    public function save(Supplier $supplier) : int|false
    {
        // first save to person table
        // then to supplier table
        // refer Customer::save
        return false;
    }

    /**
     * Delete a supplier.
     * 
     * @todo implement delete functionality.
     */
    public function delete(int $id) : bool
    {
        // update set deleted = true
        return false;
    }
}