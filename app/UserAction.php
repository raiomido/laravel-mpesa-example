<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserAction
 *
 * @package App
 * @property string $user
 * @property string $action
 * @property string $action_model
 * @property integer $action_id
*/
class UserAction extends Model
{

    protected $fillable = ['action', 'action_model', 'action_id', 'user_id'];


    public static function storeValidation($request)
    {
        return [
            'user_id' => 'integer|exists:users,id|max:4294967295|required',
            'action' => 'max:191|required',
            'action_model' => 'max:191|nullable',
            'action_id' => 'integer|max:2147483647|nullable'
        ];
    }

    public static function updateValidation($request)
    {
        return [
            'user_id' => 'integer|exists:users,id|max:4294967295|required',
            'action' => 'max:191|required',
            'action_model' => 'max:191|nullable',
            'action_id' => 'integer|max:2147483647|nullable'
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
