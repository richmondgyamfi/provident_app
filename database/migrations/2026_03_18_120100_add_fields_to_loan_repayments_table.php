<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('loan_repayments', function (Blueprint $table) {
            $table->string('payment_method')->nullable()->after('installment_number');
            $table->string('reference')->nullable()->after('payment_method');
            $table->text('notes')->nullable()->after('reference');
            $table->foreignId('loan_repayment_upload_id')->nullable()->after('notes')->constrained()->onDelete('set null');
            $table->foreignId('recorded_by')->nullable()->after('loan_repayment_upload_id')->constrained('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('loan_repayments', function (Blueprint $table) {
            $table->dropForeign(['loan_repayment_upload_id']);
            $table->dropForeign(['recorded_by']);
            $table->dropColumn(['payment_method', 'reference', 'notes', 'loan_repayment_upload_id', 'recorded_by']);
        });
    }
};
