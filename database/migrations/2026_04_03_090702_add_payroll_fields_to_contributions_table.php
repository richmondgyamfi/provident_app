<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up(): void
    {
        Schema::table('contributions', function (Blueprint $table) {
            $table->decimal('employee_amount', 12, 2)->default(0)->after('contribution_amount');
            $table->decimal('employer_amount', 12, 2)->default(0)->after('employee_amount');
            $table->decimal('basic_salary', 12, 2)->nullable()->after('employer_amount');
            $table->enum('contribution_type', ['Mandatory', 'Voluntary', 'Arrears', 'Adjustment'])->default('Mandatory')->after('basic_salary');
            $table->string('payment_reference')->nullable()->after('contribution_type');
            $table->text('notes')->nullable()->after('payment_reference');
        });
    }

    /**
     * Reverse the migrations.
     */
public function down(): void
    {
        Schema::table('contributions', function (Blueprint $table) {
            $table->dropColumn(['employee_amount', 'employer_amount', 'basic_salary', 'contribution_type', 'payment_reference', 'notes']);
        });
    }
};
