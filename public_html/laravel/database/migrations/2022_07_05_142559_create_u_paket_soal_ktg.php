<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUPaketSoalKtg extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('u_paket_soal_ktg', function (Blueprint $table) {
            $table->id();
            $table->integer('fk_user_id');
            $table->integer('fk_u_paket_soal_mst');
            $table->string('judul');
            $table->mediumText('ket')->nullable();
            $table->integer('kkm')->comment = '0 - 100';
            $table->integer('nilai')->nullable()->default('0')->comment = '0 - 100';
            $table->integer('point')->default('0')->nullable();
            $table->integer('jumlah_soal')->default('0');
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
        Schema::dropIfExists('u_paket_soal_ktg');
    }
}
