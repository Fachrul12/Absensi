<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePesertasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pesertas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_peserta');
            $table->unsignedBigInteger('partai_id');
            $table->unsignedBigInteger('pendukung_calon_id');
            $table->string('foto_peserta');
            $table->unsignedBigInteger('event_id');
            $table->string('qr_code');
            $table->timestamps();

            $table->foreign('partai_id')->references('id')->on('partais');
            $table->foreign('pendukung_calon_id')->references('id')->on('pendukung_calons');
            $table->foreign('event_id')->references('id')->on('events');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pesertas');
    }
}
