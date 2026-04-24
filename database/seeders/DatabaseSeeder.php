<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Roles
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

        $adminRole = Role::where('slug', 'admin')->first();
        $superAdminRole = Role::where('slug', 'super_admin')->first();

        // $adminUser = User::create([
        //     'fname' => 'Admin',
        //     'lname' => 'User',
        //     'email' => 'richmond.nketia@ucc.edu.gh',
        //     'phone_no' => '0541234567',
        //     'staff_no' => '15876',
        //     'date_of_birth' => '1990-01-01',
        //     'company' => 'UCC',
        //     'job_title' => 'Administrator',
        //     'account_type' => 'admin',
        //     'password' => bcrypt('password'),
        //     // 'api_key' => Str::random(32),
        //     'is_active' => true,
        // ]);

        // $adminUser->roles()->attach($adminRole);

        $superUser = User::create([
            'fname' => 'Super',
            'lname' => 'Admin',
            'email' => 'rnketia25@gmail.com',
            'phone_no' => '0547654321',
            'staff_no' => 'SUPER001',
            'account_type' => 'admin',
            'password' => bcrypt('password'),
            // 'api_key' => Str::random(32),
            'is_active' => true,
        ]);

        // $superUser->roles()->attach($superAdminRole);

        $this->call(ContributionSeeder::class);
    }
}
