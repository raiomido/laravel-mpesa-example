<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Transaction
 *
 * @package App
 * @property string $reference
 * @property int $type
 * @property int $amount
 * @property int $cost
 * @property string $currency_code
 * @property int $status
*/
class Transaction extends Model
{
    use SoftDeletes;


    protected $fillable = [
        'reference',
        'type',
        'amount',
        'cost',
        'currency_code',
        'status',
    ];


    public static $enum_type = ["DEBIT" => "DEBIT", "CREDIT" => "CREDIT"];

    public static $enum_status = ["PROCESSING" => "PROCESSING", "COMPLETE" => "COMPLETE", "CANCELLED" => "CANCELLED"];


    public function transactable()
    {
        return $this->morphTo();
    }

    public function loggable()
    {
        return $this->morphTo();
    }


}
