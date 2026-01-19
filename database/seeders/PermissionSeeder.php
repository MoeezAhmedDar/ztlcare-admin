<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define all your permissions based on sidebar menu items
        $permissions = [
            // Management
            'view job applications',
            'view invite letters',
            'view interviews',
            'view offer letters',
            'view rejection letters',
            'view character certificates',
            'view reference requests',
            'view custom letters',

            // Configuration
            'manage questionnaire',
            'manage users',
        ];

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Get the specific user by email
        $user = User::where('email', 'moeezahmed448@gmail.com')->first();

        if ($user) {
            // Assign ALL permissions directly to this user
            $user->givePermissionTo(Permission::all());

            $this->command->info('All permissions assigned directly to user: ' . $user->email);
        } else {
            $this->command->warn('User with email moeezahmed448@gmail.com not found. Make sure the user exists.');
        }
    }
}