<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
        ], [
            'password' => 'testroot',
            'role' => User::ADMIN,
        ]);

        User::firstOrCreate([
            'name' => 'Customer',
            'email' => 'customer@gmail.com',
        ], [
            'password' => 'testroot',
            'role' => User::CUSTOMER,
        ]);

        $this->call(CategorySeeder::class);
    }
}
