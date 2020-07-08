<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Mpesa
 *
 * @package App
 * @property string $type
 * @property string $time
 * @property string $mpesa_transaction_id
 * @property string $amount
 * @property string $short_code
 * @property string $bill_ref_number
 * @property string $invoice_number
 * @property string $msisdn
 * @property string $firstname
 * @property string $middlename
 * @property string $lastname
 * @property string $org_account_balance
 */
class Mpesa extends Model
{
    use SoftDeletes;


    protected $fillable = [
        'type',
        'time',
        'mpesa_transaction_id',
        'amount',
        'short_code',
        'bill_ref_number',
        'invoice_number',
        'msisdn',
        'firstname',
        'middlename',
        'lastname',
        'org_account_balance'
    ];

    public static function boot()
    {
        parent::boot();

        Mpesa::observe(new \App\Misc\Observers\UserActionsObserver);
    }

    public function transactions()
    {
        return $this->morphMany(Transaction::class, 'loggable');
    }
}
