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
        Schema::create('barang_peminjaman', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('peminjaman_id'); 
            $table->unsignedInteger('barang_id'); 
            $table->integer('jumlah'); 
            $table->string('keterangan')->nullable();
            $table->index('peminjaman_id');
            $table->index('barang_id');
            $table->foreign('peminjaman_id')->references('id')->on('peminjaman')
            ->onDelete('cascade')->onUpdate('cascade'); 
            $table->foreign('barang_id')->references('id')->on('barang')
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
