<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AccountEntry
 *
 * @package App
 * @property string $reference
 * @property string $type
 * @property string $balance_before
 * @property integer $balance_after
 * @property int $amount
*/
class AccountEntry extends Model
{
    protected $fillable = ['reference', 'type', 'balance_before', 'balance_after', 'amount'];
}
