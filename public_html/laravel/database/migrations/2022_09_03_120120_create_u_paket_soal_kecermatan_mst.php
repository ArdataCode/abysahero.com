<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUPaketSoalKecermatanMst extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('u_paket_soal_kecermatan_mst', function (Blueprint $table) {
            $table->id();
            $table->integer('fk_user_id');
            $table->integer('fk_paket_soal_kecermatan_mst');
            $table->string('judul');
            $table->integer('kkm')->comment = '0 - 100';
            $table->integer('nilai')->nullable()->default('0')->comment = '0 - 100';
            $table->datetime('mulai')->nullable();
            $table->datetime('selesai')->nullable();
            $table->integer('is_mengerjakan')->default('0')->comment = '0 = Belum Mengerjakan ; 1 = Sedang Mengerjakan ; 2 = Selesai Mengerjakan';
            $table->integer('total_soal')->default('0');
            $table->mediumText('ket')->nullable();
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
        Schema::dropIfExists('u_paket_soal_kecermatan_mst');
    }
}
