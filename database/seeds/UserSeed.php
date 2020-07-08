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
                'email' => 'raiomido@gmail.com',
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
            $u->roles()->sync([1]);
            event(new Registered($u));
        }
    }
}
