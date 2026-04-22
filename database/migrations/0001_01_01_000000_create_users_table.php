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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('fname');
            $table->string('mname')->nullable();
            $table->string('lname');
            $table->string('email')->unique();
            $table->string('phone_no');
            $table->string('staff_no');
            $table->string('account_type')->default('free');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('date_of_birth')->nullable();
            $table->string('company')->nullable();
            $table->string('job_title')->nullable();
            // $table->enum('role', [
            //     'staff',
            //     'director',
            //     'vc',
            //     'payroll',
            //     'super_admin',
            //     'admin'
            // ])->default('staff');
            // $table->string('api_key')->unique();
            $table->boolean('is_active')->default(false);
            // make user inactive if not active for 6 month
            $table->date('last_active_at')->nullable();
            $table->rememberToken()->nullable();
            $table->integer('status')->default('1');
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
