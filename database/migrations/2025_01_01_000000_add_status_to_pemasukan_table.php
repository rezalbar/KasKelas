<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pemasukan', function (Blueprint $table) {
            // Kolom buat simpan nama file gambar
            $table->string('foto_bukti')->nullable()->after('keterangan');
            
            // Kolom status (default 'lunas' biar data lama aman)
            $table->enum('status', ['pending', 'lunas', 'ditolak'])->default('lunas')->after('foto_bukti');
        });
    }

    public function down()
    {
        Schema::table('pemasukan', function (Blueprint $table) {
            $table->dropColumn(['foto_bukti', 'status']);
        });
    }
};