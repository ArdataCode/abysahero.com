<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUPaketSoalKecermatanSoalDtl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('u_paket_soal_kecermatan_soal_dtl', function (Blueprint $table) {
            $table->id();
            $table->integer('fk_u_paket_soal_kecermatan_mst');
            $table->integer('fk_u_paket_soal_kecermatan_soal_mst');
            $table->string('soal');
            $table->string('jawaban');
            $table->string('jawaban_user');
            $table->integer('benar_salah')->default('0');
            $table->integer('waktu')->comment = 'Detik';
            $table->integer('detik_mulai')->nullable();
            $table->integer('detik_akhir')->nullable();
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
        Schema::dropIfExists('u_paket_soal_kecermatan_soal_dtl');
    }
}
