<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('loan_repayment_uploads', function (Blueprint $table) {
            $table->id();
            $table->string('filename');
            $table->string('file_path');
            $table->unsignedInteger('records_count')->default(0);
            $table->enum('status', ['processing', 'success', 'failed'])->default('processing');
            $table->text('notes')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loan_repayment_uploads');
    }
};
