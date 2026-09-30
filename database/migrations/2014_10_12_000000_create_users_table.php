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

            // Foreign key to roles table
            $table->foreignId('role_id')
                ->constrained('roles')
                ->restrictOnDelete();

            // Foreign key to branches table
            $table->foreignId('branch_id')
                ->nullable()
                ->constrained('branches')
                ->nullOnDelete();

            $table->string('name', 150);

            $table->string('email', 150)
                ->unique();

            $table->string('password', 255);

            $table->string('phone', 30)
                ->nullable();

            $table->enum('status', ['active', 'inactive'])
                ->default('active');

            $table->timestamp('email_verified_at')
                ->nullable();

            $table->rememberToken();

            $table->timestamps();

            // Indexes
            $table->index('role_id', 'idx_users_role');
            $table->index('branch_id', 'idx_users_branch');
            $table->index('status', 'idx_users_status');
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
