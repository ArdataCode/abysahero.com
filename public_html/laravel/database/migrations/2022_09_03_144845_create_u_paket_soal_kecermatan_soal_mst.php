<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUPaketSoalKecermatanSoalMst extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('u_paket_soal_kecermatan_soal_mst', function (Blueprint $table) {
            $table->id();
            $table->integer('fk_u_paket_soal_kecermatan_mst');
            $table->integer('fk_kategori_soal_kecermatan');
            $table->string('judul_kategori');
            $table->string('karakter');
            $table->string('kiasan');
            $table->datetime('mulai')->nullable();
            $table->datetime('selesai')->nullable();
            $table->integer('is_mengerjakan')->default('0')->comment = '0 = Belum Mengerjakan ; 1 = Sedang Mengerjakan ; 2 = Selesai Mengerjakan';
            $table->integer('waktu')->comment = 'Detik';
            $table->integer('created_by');
            $table->datetime('created_at');
            $table->integer('updated_by')->nullable();
            $table->datetime('updated_at')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->datetime('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('u_paket_soal_kecermatan_soal_mst');
    }
}
