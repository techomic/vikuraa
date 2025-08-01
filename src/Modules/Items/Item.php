<?php

namespace Vikuraa\Modules\Items;

use Vikuraa\Core\Entity;
use Vikuraa\Modules\Suppliers\Supplier;

class Item extends Entity
{
    protected ?int $id;
    protected string $name;
    protected string $category;
    protected ?int $supplierId;
    protected ?string $itemNumber;
    protected string $description;
    protected float $costPrice;
    protected float $unitPrice;
    protected ?float $reorderLevel;
    protected ?float $receivingQuantity;
    protected ?string $picFilename;
    protected bool $allowAltDescription;
    protected bool $isSerialized;
    protected ?bool $stockType;
    protected ?int $itemType;
    protected ?bool $deleted;
    protected ?int $taxCategoryId;
    protected ?float $qtyPerPack;
    protected ?string $packName;
    protected ?int $lowSellItemId;
    protected ?string $hsnCode;
    protected ?Supplier $supplier;


    public static function fromDbArray(array $data): static
    {
        $item = new self();
        $item->id                   = $data['id'];
        $item->name                 = $data['name'];
        $item->category             = $data['category'];
        $item->supplierId           = $data['supplier_id'];
        $item->itemNumber           = $data['item_number'];
        $item->description          = $data['description'];
        $item->costPrice            = $data['cost_price'];
        $item->unitPrice            = $data['unit_price'];
        $item->reorderLevel         = $data['reorder_level'];
        $item->receivingQuantity    = $data['receiving_quantity'];
        $item->picFilename          = $data['pic_filename'];
        $item->allowAltDescription  = $data['allow_alt_description'];
        $item->isSerialized         = $data['is_serialized'];
        $item->stockType            = $data['stock_type'];
        $item->itemType             = $data['item_type'];
        $item->deleted              = $data['deleted'];
        $item->taxCategoryId        = $data['tax_category_id'];
        $item->qtyPerPack           = $data['qty_per_pack'];
        $item->packName             = $data['pack_name'];
        $item->lowSellItemId        = $data['low_sell_item_id'];
        $item->hsnCode              = $data['hsn_code'];

        return $item;
    }

    public function setSupplierFromDbArray(array $data) : void
    {
        $this->supplier = Supplier::fromDbArray([
            'person_id'     => $data['supplier_id'],
            'company_name'  => $data['supplier_company_name'],
            'agency_name'   => $data['supplier_agency_name'],
            'account_number' => $data['supplier_account_number'],
            'tax_id'        => $data['supplier_tax_id'],
            'deleted'       => $data['supplier_deleted'],
            'category'      => $data['supplier_category'],
        ]);
    }
}
