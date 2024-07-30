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
        $table->string('foto_peserta')->nullable();
        $table->unsignedBigInteger('event_id')->nullable();
        $table->unsignedBigInteger('isi_kategori_peserta_id')->nullable();
        $table->string('qr_code')->nullable();
        $table->timestamps();        
        $table->foreign('event_id')->references('id')->on('events');
        $table->foreign('isi_kategori_peserta_id')->references('id')->on('isi_kategori_pesertas');
    });
}

public function down()
{
    Schema::table('pesertas', function (Blueprint $table) {
        $table->dropColumn('foto_peserta');
    });
}
}
