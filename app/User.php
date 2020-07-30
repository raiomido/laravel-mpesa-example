<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;
use Hash;

/**
 * Class User
 *
 * @package App
 * @property string $name
 * @property string $username
 * @property string $phone
 * @property string $designation
 * @property string $email
 * @property string $identification_number
 * @property string $payroll_number
 * @property string $member_number
 * @property string $kra_pin
 * @property string $personal_number
 * @property string $ministry
 * @property string $county
 * @property string $password
 * @property string $active
 * @property string $email_verified_at
 */
class User extends Authenticatable implements MustVerifyEmail
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'phone',
        'email',
        'designation',
        'active',
        'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['first_name', 'last_name'];

    public static function storeValidation($request)
    {
        return [
            'name' => 'max:191|required',
            'email' => 'email|max:191|required|unique:users,email,' . $request->route('user'),
            'role' => 'array|required',
            'role.*' => 'integer|exists:roles,id|max:4294967295|required',
            'username' => 'max:191|required|unique:users,username,' . $request->route('user'),
            'designation' => 'max:191|nullable',
            'phone' => 'max:191|nullable',
            'about' => 'max:65535|nullable',
            'password' => ''
        ];
    }

    public static function updateValidation($request)
    {
        return [
            'name' => 'max:191|required',
            'email' => 'email|max:191|required|unique:users,email,' . $request->route('user'),
            'role' => 'array|required',
            'role.*' => 'integer|exists:roles,id|max:4294967295|required',
            'username' => 'max:191|required|unique:users,username,' . $request->route('user'),
            'designation' => 'max:191|nullable',
            'phone' => 'max:191|nullable',
            'about' => 'max:65535|nullable',
            'password' => ''
        ];
    }

    public function getRouteKeyName()
    {
        return 'username';
    }

    /**
     * Hash password
     * @param $input
     */
    public function setPasswordAttribute($input)
    {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }

    /**
     * Set attribute to username
     * @param $input
     */
    public function setUsernameAttribute($input)
    {
        if ($input) {
            $username = Str::slug($input);
            do {
                $this->attributes['username'] = $username;
                $exists = User::where('username', $username)->where('id', '!=', $this->id)->first();
                $username = Str::slug($input) . mt_rand(10, 10000);
            } while ($exists);
        }
    }

    public function account()
    {
        return $this->morphOne(Account::class, 'accountable');
    }

    public function getFirstNameAttribute()
    {
        $nameArr = explode(' ', $this->name);
        return $nameArr[0] ?? $this->name;
    }

    public function getLastNameAttribute()
    {
        $nameArr = explode(' ', $this->name);
        return $nameArr[-1] ?? $this->name;
    }
}
