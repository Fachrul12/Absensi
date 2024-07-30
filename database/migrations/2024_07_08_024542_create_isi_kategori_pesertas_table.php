<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIsiKategoriPesertasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('isi_kategori_pesertas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_isi_kategori_peserta');            
            $table->unsignedBigInteger('kategori_peserta_id')->nullable();
            $table->timestamps();

            $table->foreign('kategori_peserta_id')->references('id')->on('kategori_pesertas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('isi_kategori_pesertas');
    }
}
