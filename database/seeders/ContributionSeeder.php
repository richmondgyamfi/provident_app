<?php

namespace Database\Seeders;

use App\Models\Contribution;
use App\Models\Member;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContributionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $members = Member::inRandomOrder()->limit(5)->get();
        foreach ($members as $member) {
            Contribution::factory()->count(3)->create([
                'member_id' => $member->id,
                'staff_no' => $member->staff_no,
                'payroll_year' => 2024,
                'payroll_month' => rand(1,12),
                'employee_amount' => rand(50,200) + (rand(0,99)/100),
                'employer_amount' => rand(100,400) + (rand(0,99)/100),
                'basic_salary' => rand(1000,5000) + (rand(0,99)/100),
                'contribution_type' => ['Mandatory', 'Voluntary', 'Arrears', 'Adjustment'][rand(0,3)],
                'status' => ['pending', 'approved', 'rejected'][rand(0,2)],
            ]);
        }
    }
}
