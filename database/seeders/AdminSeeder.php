<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminUser = User::create([
            'name' => 'Admin',
            'email' => 'kannanmuruganandham1@gmail.com',
            'password' => bcrypt('Kannan@2409'),
        ]);

        $adminUser->assignRole('admin');
    }
}
