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
            $table->string('name');
            $table->string('email')->unique();
            $table->string('nim')->unique();
            $table->string('prodi')->nullable();
            $table->integer('angkatan');
            $table->string('phone')->nullable();
            $table->string('ktm')->nullable();
            $table->text('alasan_bergabung');
            $table->enum('role', ['admin', 'user', 'anggota'])->default('user');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('is_verified')->default(false);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
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