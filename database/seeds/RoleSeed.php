<?php

use Illuminate\Database\Seeder;

class RoleSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            
            ['id' => 1, 'title' => 'Staff',],
            ['id' => 2, 'title' => 'Customer',],

        ];

        foreach ($items as $item) {
            \App\Role::create($item);
        }
    }
}
