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
        $adminUser = User::firstOrCreate([
            'name' => 'Duo Dev Technologies',
            'email' => 'duodevtechnologies@gmail.com',
            'password' => bcrypt('DuoDev@123'),
        ]);

        $adminUser->syncRoles(['admin']);
    }
}
