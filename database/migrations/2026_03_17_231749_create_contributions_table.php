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
        Schema::create('contributions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained()->cascadeOnDelete();
            $table->string('staff_no');
            $table->foreignId('payroll_upload_id')->nullable()->constrained()->nullOnDelete();
            $table->string('uploaded_by');
            $table->decimal('contribution_amount', 12,2);
            $table->year('payroll_year');
            $table->integer('payroll_month');
            $table->enum('source', ['payroll', 'manual'])->default('payroll');
            $table->string('status')->default('paid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contributions');
    }
};
