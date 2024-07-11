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
        $table->string('foto_peserta')->nullable();
        $table->unsignedBigInteger('event_id')->nullable();
        $table->string('qr_code')->nullable();
        $table->timestamps();

        $table->foreign('partai_id')->references('id')->on('partais');
        $table->foreign('pendukung_calon_id')->references('id')->on('pendukung_calons');
        $table->foreign('event_id')->references('id')->on('events');
    });
}

public function down()
{
    Schema::table('pesertas', function (Blueprint $table) {
        $table->dropColumn('foto_peserta');
    });
}
}
