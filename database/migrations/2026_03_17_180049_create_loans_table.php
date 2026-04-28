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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('loan_type_id')->constrained()->cascadeOnDelete();
            $table->decimal('amount', 12, 2);
            $table->decimal('interest_rate', 5, 2);
            $table->integer('term_months');
            $table->decimal('monthly_payment', 12, 2);
            $table->decimal('total_repayable', 12, 2);
            $table->decimal('outstanding_balance', 12, 2);
            $table->string('chk_read')->default('off');
            $table->string('chk_accurate')->default('off');
            $table->string('chk_deduction')->default('off');
            $table->string('chk_default')->default('off');
            $table->string('chk_signature')->default('off');
            $table->string('fullname')->nullable();
            $table->date('signed_date')->nullable();
            $table->string('doc_id')->nullable();
            $table->string('doc_payslip')->nullable();
            $table->string('doc_letter')->nullable();
            $table->string('doc_bank')->nullable();
            $table->string('doc_purpose')->nullable();
            $table->string('doc_other')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected', 'disbursed'])->default('pending');
            $table->string('purpose')->nullable();
            $table->string('application_ref')->unique();
            $table->string('approved_by')->nullable();
            $table->timestamp('disbursed_at')->nullable();
            $table->string('documents_path')->nullable();
            $table->string('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
