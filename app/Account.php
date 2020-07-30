<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Class Account
 *
 * @package App
 * @property string $number
 * @property int $balance
 * @property int $transactions
 * @property int $entries
 */
class Account extends Model
{
    protected $fillable = ['number', 'balance'];

    public function accountable()
    {
        return $this->morphTo();
    }

    public function entries()
    {
        return $this->morphMany(AccountEntry::class, 'entryable');
    }

    public function transactions()
    {
        return $this->morphMany(Transaction::class, 'transactable');
    }

    /**
     * Set Account Number
     * @param $input
     */
    public function setNumberAttribute($input)
    {
        if ($input) {
            do {
                $this->attributes['number'] = $number = $this->generateAccountNumber();
                $exists = Account::where('number', $number)->where('id', '!=', $this->id)->first();
            } while ($exists);
        }
    }

    private function generateAccountNumber()
    {
        return strtoupper(Str::random(8));
    }
}
