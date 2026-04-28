<?php

namespace Database\Seeders;

use App\Models\LoanType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LoanTypeSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $loanTypes = [
            [
                'name' => 'Member Loan',
                'slug' => 'member-loan',
                'description' => 'Loan available to active members of the provident fund with favorable interest rates.',
                'interest_rate' => 14.00,
                'max_amount' => 500000.00,
                'max_term_months' => 60,
                'is_active' => true,
            ],
            [
                'name' => 'Non-Member Loan',
                'slug' => 'non-member-loan',
                'description' => 'Loan available to non-members with standard interest rates.',
                'interest_rate' => 16.00,
                'max_amount' => 200000.00,
                'max_term_months' => 36,
                'is_active' => true,
            ],
        ];

        foreach ($loanTypes as $loanType) {
            LoanType::firstOrCreate(
                ['name' => $loanType['name']],
                $loanType
            );
        }
    }
}

