<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
// database/seeders/PermissionSeeder.php (or inside RoleSeeder::run())

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Create permissions (firstOrCreate avoids duplicates)
        $permissions = [
            'view.dashboard',
            'view.job-applications',
            'view.invite-letter',
            'view.interviews',
            'view.offer-letter',
            'view.rejection-letter',
            'view.character-certificate',
            'view.reference-request',
            'view.custom-letters',
            'manage.questionnaire',
            'manage.users',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // Get or create admin role
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // Give ALL permissions to admin role
        $adminRole->syncPermissions($permissions);

        $this->command->info('Permissions created and assigned to admin role!');
    }
}
