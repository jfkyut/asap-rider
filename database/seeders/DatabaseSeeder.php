<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $users = [
            [
                'name' => 'Admin User',
                'email' => 'admin@admin.admin',
                'phone' => '0987654321',
                'password' => Hash::make('adminadmin'),
                'role' => 'admin',
            ],
            [
                'name' => 'Role User',
                'email' => 'test@test.test',
                'phone' => '1234567890',
                'password' => Hash::make('testtest'),
                'role' => 'user',
            ],
            [
                'name' => 'Rider',
                'email' => 'rider@rider.rider',
                'phone' => '9876543210',
                'password' => Hash::make('riderrider'),
                'role' => 'rider',
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
