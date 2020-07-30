<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class STKPush
 * @package App
 * @property string $business_short_code
 * @property string $password
 * @property string $timestamp
 * @property string $transaction_type
 * @property string $amount
 * @property string $party_a
 * @property string $party_b
 * @property string $phone_number
 * @property string $callback_url
 * @property string $account_reference
 * @property string $transaction_desc
 */
class STKPush extends Model
{
    protected $fillable = [
        'business_short_code',
        'password',
        'timestamp',
        'transaction_type',
        'amount',
        'party_a',
        'party_b',
        'phone_number',
        'callback_url',
        'account_reference',
        'transaction_desc',
    ];

    protected $table = 'mpesa_stk_push';
}
