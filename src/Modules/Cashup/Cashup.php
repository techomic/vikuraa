<?php

namespace Vikuraa\Modules\Cashup;

use Vikuraa\Core\Entity;
use DateTime;

class Cashup extends Entity
{
    protected ?int $id;
    protected ?DateTime $openDate;
    protected ?DateTime $closeDate;
    protected float $openAmountCash;
    protected float $transferAmountCash;
    protected int $note;
    protected float $closedAmountCash;
    protected float $closedAmountCard;
    protected float $closedAmountCheck;
    protected float $closedAmountTotal;
    protected string $description;
    protected int $openEmployeeId;
    protected int $closeEmployeeId;
    protected bool $deleted;
    protected float $closedAmountDue;

    public static function fromDbArray(array $data) : static
    {
        $cashup = new static();
        $cashup->id = $data['id'];
        $cashup->openDate = $data['open_date'] == null ? null : new DateTime($data['open_date']);
        $cashup->closeDate = $data['close_date'] == null ? null : new DateTime($data['close_date']);
        $cashup->openAmountCash = $data['open_amount_cash'];
        $cashup->transferAmountCash = $data['transfer_amount_cash'];
        $cashup->note = $data['note'];
        $cashup->closedAmountCash = $data['closed_amount_cash'];
        $cashup->closedAmountCard = $data['closed_amount_card'];
        $cashup->closedAmountCheck = $data['closed_amount_check'];
        $cashup->closedAmountTotal = $data['closed_amount_total'];
        $cashup->description = $data['description'];
        $cashup->openEmployeeId = $data['open_employee_id'];
        $cashup->closeEmployeeId = $data['close_employee_id'];
        $cashup->deleted = $data['deleted'];
        $cashup->closedAmountDue = $data['closed_amount_due'];
        return $cashup;
    }
}