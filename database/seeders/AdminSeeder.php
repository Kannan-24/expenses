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
        // Find or create the admin user 
        $adminUser = User::firstOrCreate(
            ['email' => 'duodevtechnologies@gmail.com'],
            [
                'name' => 'Duo Dev Technologies',
                'password' => bcrypt('DuoDev@123'),
                'email_verified_at' => now(),
            ]
        );

        $adminUser->syncRoles(['admin']);
    }
}
