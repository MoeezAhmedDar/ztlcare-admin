<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Model\User;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create or update the 'admin' role
        Role::updateOrCreate(
            ['name' => 'admin'],
            ['guard_name' => 'web'] // default guard, change if using API or other
        );

        // Create or update the 'applicant' role
        Role::updateOrCreate(
            ['name' => 'applicant'],
            ['guard_name' => 'web']
        );

        $role = Role::where('name','admin')->first();

        $user = User::where('email','moeezahmed448@gmail.com')->first();

        $user->roles()->attach($role->id);
        // Optional: Add a simple message to console
        $this->command->info('Roles "admin" and "applicant" created successfully!');
    }
}
