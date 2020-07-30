<?php

use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\Seeder;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'id' => 1,
                'name' => 'Rai Omido',
                'username' => 'raiomido',
                'email' => env('MAIL_FROM_ADDRESS'),
                'phone' => NULL,
                'designation' => NULL,
                'email_verified_at' => now(),
                'password' => 'password',
                'remember_token' => NULL,
                'active' => 1,
            ],
        ];

        foreach ($users as $user) {
            $u = User::create($user);
            event(new Registered($u));
        }
    }
}
