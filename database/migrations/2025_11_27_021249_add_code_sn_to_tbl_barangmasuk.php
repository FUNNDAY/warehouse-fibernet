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
        Schema::table('tbl_barangmasuk', function (Blueprint $table) {
            // MENAMBAHKAN KOLOM DISINI:
            // nullable() artinya kolom ini boleh kosong (penting agar data lama tidak error)
            // after('barang_kode') artinya kolom ini diletakkan setelah kolom 'barang_kode'
            $table->string('code_sn')->nullable()->after('barang_kode');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_barangmasuk', function (Blueprint $table) {
            // MENGHAPUS KOLOM DISINI (jika migrasi dibatalkan):
            $table->dropColumn('code_sn');
        });
    }
};
