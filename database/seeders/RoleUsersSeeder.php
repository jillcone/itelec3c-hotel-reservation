<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RoleUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'role' => 'Admin',
                'full_name' => 'System Admin',
                'username' => 'admin',
                'email' => 'admin@aurum.test',
                'password' => 'password',
            ],
            [
                'role' => 'Employee',
                'full_name' => 'Front Desk Employee',
                'username' => 'employee',
                'email' => 'employee@aurum.test',
                'password' => 'password',
            ],
            [
                'role' => 'Customer',
                'full_name' => 'Sample Customer',
                'username' => 'customer',
                'email' => 'customer@aurum.test',
                'password' => 'password',
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['username' => $user['username']],
                [
                    'role' => $user['role'],
                    'full_name' => $user['full_name'],
                    'email' => $user['email'],
                    'password' => Hash::make($user['password']),
                ]
            );
        }
    }
}
