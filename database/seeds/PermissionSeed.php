<?php

use Illuminate\Database\Seeder;

class PermissionSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            ['id' => 1, 'title' => 'user_management_access',],
            ['id' => 2, 'title' => 'permission_access',],
            ['id' => 3, 'title' => 'permission_create',],
            ['id' => 4, 'title' => 'permission_edit',],
            ['id' => 5, 'title' => 'permission_view',],
            ['id' => 6, 'title' => 'permission_delete',],
            ['id' => 7, 'title' => 'role_access',],
            ['id' => 8, 'title' => 'role_create',],
            ['id' => 9, 'title' => 'role_edit',],
            ['id' => 10, 'title' => 'role_view',],
            ['id' => 11, 'title' => 'role_delete',],
            ['id' => 12, 'title' => 'user_access',],
            ['id' => 13, 'title' => 'user_create',],
            ['id' => 14, 'title' => 'user_edit',],
            ['id' => 15, 'title' => 'user_view',],
            ['id' => 16, 'title' => 'user_delete',],
            ['id' => 17, 'title' => 'transaction_logs_access',],
            ['id' => 18, 'title' => 'transaction_access',],
            ['id' => 19, 'title' => 'transaction_create',],
            ['id' => 20, 'title' => 'transaction_edit',],
            ['id' => 21, 'title' => 'transaction_view',],
            ['id' => 22, 'title' => 'transaction_delete',],
            ['id' => 23, 'title' => 'account_access',],
            ['id' => 24, 'title' => 'account_create',],
            ['id' => 25, 'title' => 'account_edit',],
            ['id' => 26, 'title' => 'account_view',],
            ['id' => 27, 'title' => 'account_delete',],
            ['id' => 28, 'title' => 'account_entry_access',],
            ['id' => 29, 'title' => 'account_entry_create',],
            ['id' => 30, 'title' => 'account_entry_edit',],
            ['id' => 31, 'title' => 'account_entry_view',],
            ['id' => 32, 'title' => 'account_entry_delete',],
            ['id' => 33, 'title' => 'mpesa_access',],
            ['id' => 34, 'title' => 'mpesa_create',],
            ['id' => 35, 'title' => 'mpesa_edit',],
            ['id' => 36, 'title' => 'mpesa_view',],
            ['id' => 37, 'title' => 'mpesa_delete',],
        ];

        foreach ($items as $item) {
            \App\Permission::create($item);
        }
    }
}
