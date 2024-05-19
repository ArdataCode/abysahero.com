<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUPaketSoalDtl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('u_paket_soal_dtl', function (Blueprint $table) {
            $table->id();
            $table->integer('fk_user_id');
            $table->integer('fk_u_paket_soal_mst');
            $table->integer('fk_u_paket_soal_ktg');
            $table->integer('no_soal');
            $table->mediumText('soal');
            $table->mediumText('a');
            $table->mediumText('b');
            $table->mediumText('c');
            $table->mediumText('d');
            $table->mediumText('e');
            $table->integer('point_a');
            $table->integer('point_b');
            $table->integer('point_c');
            $table->integer('point_d');
            $table->integer('point_e');
            $table->integer('max_point');
            $table->string('jawaban',20);
            $table->mediumText('pembahasan')->nullable();
            $table->string('jawaban_user',20)->nullable();
            $table->integer('benar_salah')->default('0');
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
        Schema::dropIfExists('u_paket_soal_dtl');
    }
}
