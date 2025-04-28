<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nim')->nullable()->after('name');
            $table->string('prodi')->nullable()->after('nim');
            $table->string('angkatan')->nullable()->after('prodi');
            $table->string('phone')->nullable()->after('angkatan');
            $table->string('ktm')->nullable()->after('phone');
            $table->text('alasan_bergabung')->nullable()->after('ktm');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('nim');
            $table->dropColumn('prodi');
            $table->dropColumn('angkatan');
            $table->dropColumn('phone');
            $table->dropColumn('ktm');
            $table->dropColumn('alasan_bergabung');
        });
    }
};
