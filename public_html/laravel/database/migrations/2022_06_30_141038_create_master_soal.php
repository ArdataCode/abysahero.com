<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterSoal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_soal', function (Blueprint $table) {
            $table->id();
            $table->integer('fk_kategori_soal');
            $table->mediumText('soal');
            $table->mediumText('a');
            $table->mediumText('b');
            $table->mediumText('c');
            $table->mediumText('d');
            $table->mediumText('e');
            $table->string('jawaban',20);
            $table->integer('point_a')->default('0');
            $table->integer('point_b')->default('0');
            $table->integer('point_c')->default('0');
            $table->integer('point_d')->default('0');
            $table->integer('point_e')->default('0');
            $table->mediumText('pembahasan')->nullable();
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
        Schema::dropIfExists('master_soal');
    }
}
