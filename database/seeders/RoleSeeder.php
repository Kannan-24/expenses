<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = config('permission.roles');

        // Sync roles
        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['name' => $role['name']],
                ['guard_name' => 'web']
            );
        }

        // Remove roles that are not in the config
        Role::whereNotIn('name', array_column($roles, 'name'))->delete();

        // Assign permissions to roles
        foreach ($roles as $role) {
            $roleModel = Role::where('name', $role['name'])->first();
            if ($roleModel) {
                $permissions = $role['permissions'] ?? [];
                $roleModel->syncPermissions($permissions);
            }
        }
    }
}
