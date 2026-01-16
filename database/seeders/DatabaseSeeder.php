<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();


// Create a test user with realistic data
    User::factory()->create([
        'first_name'  => 'Test',
        'middle_name' => null,               // or omit if nullable
        'last_name'   => 'User',
        'email'       => 'moeezahmed448@gmail.com',
        'password'    => Hash::make('12345678'), // properly hashed
        'phone'       => '07890 123456',
        'postcode'    => 'SW1A 1AA',
        'dob'         => '1995-08-22',
    ]);

        $this->call([
            CareAssistantQuestionnaireSeeder::class,
        ]);
    }
}
