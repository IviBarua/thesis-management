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
            // Primary key
            $table->id();

            // Personal Information
            $table->string('first_name');
            $table->string('last_name');
            $table->date('birth');
            $table->enum('gender', ['male', 'female', 'other']);

            // Contact Information
            $table->string('email')->unique();
            $table->string('phone');

            // Academic Information
            $table->string('department');
            $table->string('degree');
            $table->unsignedInteger('batch');
            $table->string('session');

            // Professional Information
            $table->string('designation');
            $table->string('teacher_id')->unique();

            // Authentication
            $table->string('password');

            // Authorization
            $table->enum('role', ['admin', 'teacher'])
                  ->default('teacher');

            // Laravel authentication
            $table->rememberToken();

            // created_at and updated_at
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
