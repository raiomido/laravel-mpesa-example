<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MpesaC2B
 * @package App
 * @property string $trans_time
 * @property string $trans_amount
 * @property string $business_short_code
 * @property string $bill_ref_number
 * @property string $invoice_number
 * @property string $org_account_balance
 * @property string $third_party_trans_id
 * @property string $msisdn
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property string $trans_id
 * @property string $transaction_type
 */
class MpesaC2B extends Model
{
    protected $fillable = [
        'trans_time',
        'trans_amount',
        'business_short_code',
        'bill_ref_number',
        'invoice_number',
        'org_account_balance',
        'third_party_trans_id',
        'msisdn',
        'first_name',
        'middle_name',
        'last_name',
        'trans_id',
        'transaction_type'
    ];

    protected $table = 'mpesa_c2b';
}
