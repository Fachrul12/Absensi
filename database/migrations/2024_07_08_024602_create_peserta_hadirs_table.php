<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePesertaHadirsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peserta_hadirs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('peserta_id');
            $table->unsignedBigInteger('event_id');
            $table->date('tanggal_hadir')->nullable()->change();
            $table->timestamps();

            $table->foreign('peserta_id')->references('id')->on('pesertas');
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
        Schema::dropIfExists('peserta_hadirs');
    }
}
