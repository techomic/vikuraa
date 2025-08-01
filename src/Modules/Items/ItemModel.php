<?php

namespace Vikuraa\Modules\Items;

use Vikuraa\Core\Model;

class ItemModel extends Model
{
    public function exists(int $id): bool
    {
        $sql = "select * from items where id = :id and deleted = false";

        $args = [
            'id' => $id
        ];

        return $this->db->count($sql, $args) > 0;
    }

    public function itemNumberExists(string $itemNumber) : bool
    {
        if (boolval($this->config->getValue('allow_duplicate_barcodes'))) {
            return false;
        }

        $sql = "select * from items where item_number = :item_number deleted = false";

        $args = [
            'item_number' => $itemNumber,
        ];

        return $this->db->count($sql, $args) > 0;
    }

    public function total(): int
    {
        $sql = "select * from items where deleted = false";
        return $this->db->count($sql);
    }

    public function getTaxCategoryUsage(int $taxCategoryId): int
	{
        $sql = "select * from items where tax_category_id = :tax_category_id";
		
        $args = [
            'tax_category_id' => $taxCategoryId
        ];

		return $this->db->count($sql, $args);
	}

    public function search(
        string $search,
        array $filters,
        int $limit = 20,
        int $page = 1,
        ?string $sort = 'items.name',
        ?string $order = 'asc'
    ) : Items {
        $sql = "
            select *
            from public.items_with_suppliers_and_inventory
            where 
        ";
    }

    public function save(Item $item)
    {
        $sql = "
            insert into items (
            
            ) values (
             
            )
        ";
    }
}