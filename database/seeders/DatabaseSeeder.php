<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        // Role::factory()->count(4)->create();
        // User::factory()->create([
        //     'fname' => 'Rich',
        //     'lname' => 'Nketia',
        //     'phone_no' => 'Test User',
        //     'email' => 'rnketia25@gmail.com',
        // ]);

        Role::factory()->create([
            'name' => 'Admin',
            'slug' => 'admin',
        ]);
        Role::factory()->create([
            'name' => 'Staff',
            'slug' => 'staff',
        ]);
        Role::factory()->create([
            'name' => 'Director',
            'slug' => 'director',
        ]);
        Role::factory()->create([
            'name' => 'VC',
            'slug' => 'vc',
        ]);
        Role::factory()->create([
            'name' => 'Payroll',
            'slug' => 'payroll',
        ]);
        Role::factory()->create([
            'name' => 'Super Admin',
            'slug' => 'super_admin',
        ]);

        $this->call(ContributionSeeder::class);
    }
}
