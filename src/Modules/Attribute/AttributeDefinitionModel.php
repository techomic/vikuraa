<?php

namespace Vikuraa\Modules\Attribute;

use Vikuraa\Core\Model;
use Vikuraa\Exceptions\DatabaseException;
use DateTime;
use Vikuraa\Exceptions\NoDataException;

class AttributeDefinitionModel extends Model
{
    /**
     * Checks if a definition exists.
     * 
     * @param int $id
     * @param bool $deleted
     * @return bool
     * @throws DatabaseException if no definition is found
     */
    public function exists(int $id, bool $deleted = false): bool
    {
        $sql = "SELECT * FROM attribute_definitions WHERE id = :id AND deleted = :deleted";

        return $this->db->count($sql, ['id' => $id, 'deleted' => $deleted]) > 0;
    }

    /**
	 * Determines if a given attribute_value exists in the attribute_values table and returns the attribute_id if it does
	 *
	 * @param float|string $attributeValue The value to search for in the attribute values table.
	 * @param string $definitionType The definition type which will dictate which column is searched.
	 * @return int|bool The attribute ID of the found row or false if no attribute value was found.
	 */
	public function valueExists(float|string $attributeValue, string $definitionType = TEXT): bool|int
	{

		switch($definitionType) {
			case DATE:
				$dataType = 'date';
				$attributeDateValue = DateTime::createFromFormat($this->config->getValue('dateformat'), $attributeValue);
				$attributeValue = $attributeDateValue->format('Y-m-d');
				break;
			case DECIMAL:
				$dataType = 'decimal';
				break;
			default:
				$dataType = 'value';
				break;
		}

        $sql = "select attribute_id from attribute_values where attribute_$dataType = :attribute_value";
		
        $args = ['attribute_value' => $attributeValue];
		
        $data = $this->db->query($sql, $args);

		if(is_array($data) && count($data) > 0) {
			return $data['attribute_id'];
		}

		return false;
	}

    /**
	 * Gets information about a particular attribute definition
	 */
	public function getInfo(int $definitionId): AttributeDefinition|AttributeDefinitions
	{
        $sql = "
            select parent_definition.definition_name as definition_group, definition.*
            from attribute_definitions definition
            left join attribute_definitions parent_definition parent_definition.definition_id = definition.fk
            where definition.definition_id = :definition_id
        ";
		$args = ['definition_id' => $definitionId];

		$data = $this->db->query($sql, $args);

        if (!is_array($data)) {
            throw new NoDataException('No attribute definitions found');
        }

		if (count($data) == 1) {
			return AttributeDefinition::fromDbArray($data);
		}

        $attributeDefinitions = new AttributeDefinitions();

        $attributeDefinitions->addAllFromDbArray($data);

        return $attributeDefinitions;
	}

    /**
	 * Performs a search on attribute definitions
	 */
	public function search(string $query, ?int $limit = 0, int $offset = 0, string $sort = 'definition.definition_name', string $order = 'asc'): AttributeDefinitions
	{
        $sql = "
            select parent_definition.definition_name as definition_group, definition.*
            from attribute_definitions definition
            left join attribute_definitions parent_definition on parent_definition.definition_id = definition.fk
            wheredefinition_fk
                (
                    definition.definition_name like concat('%', cast(:query as text), '%')
                    or definition.definition_type like concat('%', cast(:query as text), '%')
                )
                and definition.deleted = false
                order by {$sort} $order
        ";

		$args = ['query' => $query];

        $data = $this->db->query($sql, $args);

        if (!is_array($data) || count($data) == 0) {
            throw new NoDataException('No attribute definitions found');
        }

		if ($limit > 0) {
            $sql .= " limit cast(:limit as int) offset cast(:offset as int) ";
            $args['limit'] = $limit;
            $args['offset'] = $offset;
        }

        $definitions = new AttributeDefinitions();
        $definitions->addAllFromDbArray($data);
		return $definitions;
	}

    /**
	 * Gets all attributes connected to an item given the item_id
	 *
	 * @param int $itemId Item to retrieve attributes for.
	 * @return array Attributes for the item.
	 */
	public function byItemId(int $itemId): AttributeDefinitions
	{
		$sql = "select * from attribute_definitions left join attribute_links on attribute_definitions.id = attribute_links.definition_id where attribute_links.item_id = :item_id and attribute_definitions.deleted = false order by definition_name";

		$args = ['item_id' => $itemId];

		$data = $this->db->query($sql, $args);

		if (!(is_array($data) && count($data) > 0)) {
			throw new NoDataException('No attribute definitions found for the item');
		}

		$attributeDefinitions = new AttributeDefinitions();

		$attributeDefinitions->addAllFromDbArray($data);

		return $attributeDefinitions;
	}

	/**
	 * @todo improve. Refer to Customer::byIds
	 */
	public function byIds(array $ids) : AttributeDefinitions
	{
		$sql = "select * from attribute_definitions where id in ((";

		$i = 1;
		foreach ($ids as $id) {
			$sql .= "{$id}";
			if ($i < count($ids)) {
				$sql .= ",";
			}

		}
		$sql .= ") or fk in (";
		$i = 1;
		foreach ($ids as $id) {
			$sql .= "{$id}";
			if ($i < count($ids)) {
				$sql .= ",";
			}
		}
		$sql .= ")) and deleted = false";

		$data = $this->db->query($sql);

		if (!(is_array($data) && count($data) > 0)) {
			throw new NoDataException('No attribute definitions found for the item');
		}

		$definitions = new AttributeDefinitions();

		$definitions->addAllFromDbArray($data);

		return $definitions;
	}

	public function total()
	{
		$sql = "select * from attribute_definitions where deleted = false";

		$count = $this->db->count($sql);

		return $count;
	}

	public function byType(string $type): AttributeDefinitions
	{
		$sql = "select * from attribute_definitions where type = :definition_type and deleted = false";

		$args = ['definition_type' => $type];
		$data = $this->db->query($sql, $args);

		if (!(is_array($data) && count($data) > 0)) {
			throw new NoDataException('No attribute definitions found');
		}

		$definitions = new AttributeDefinitions();
		$definitions->addAllFromDbArray($data);

		return $definitions;
	}

	public function byFlags(int $flag): AttributeDefinitions
	{
		$sql = "select * from attribute_definitions where flags = :flags and deleted = false";

		$args = ['flags' => $flag];

		$data = $this->db->query($sql, $args);

		if (!(is_array($data) && count($data) > 0)) {
			throw new NoDataException('No attribute definitions found');
		}

		$definitions = new AttributeDefinitions();
		$definitions->addAllFromDbArray($data);

		return $definitions;		
	}

	/**
	 * @todo complete this method
	 */
	public function save(AttributeDefinition $definition) : int|false
	{
		// save if new
		// update if exists
		return false;
	}

	public function byName(string $name, ?string $type = null) : AttributeDefinition
	{
		return AttributeDefinition::fromArray([]);
	}
}