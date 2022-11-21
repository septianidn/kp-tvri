<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailPeminjamanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_peminjaman', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_peminjaman'); 
            $table->unsignedInteger('id_peminjam'); 
            $table->unsignedInteger('id_barang'); 
            $table->string('kondisi')->nullable(); 
            $table->string('keterangan');
            $table->index('id_peminjaman');
            $table->index('id_barang');
            $table->index('id_peminjam');
            $table->foreign('id_peminjaman')->references('id')->on('peminjaman')
            ->onDelete('cascade')->onUpdate('cascade'); 
            $table->foreign('id_barang')->references('id')->on('barang')
            ->onDelete('cascade')->onUpdate('cascade'); 
            $table->foreign('id_peminjam')->references('id')->on('users')
            ->onDelete('cascade')->onUpdate('cascade'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_peminjaman');
    }
}
