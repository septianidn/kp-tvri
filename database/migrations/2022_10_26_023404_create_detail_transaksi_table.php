<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailTransaksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_transaksi', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('transaksi_id'); 
            $table->unsignedInteger('barang_id'); 
            $table->integer('jumlah'); 
            $table->string('keterangan')->nullable();
            $table->string('jenis_transaksi')->nullable()->default('peminjaman');
            $table->foreign('transaksi_id')->references('id')->on('transaksi')
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
        Schema::table('detail_transaksi', function (Blueprint $table) {
            $table->dropForeign(['barang_id']);
            $table->dropColumn('barang_id');
        });
        Schema::dropIfExists('detail_transaksi');
    }
}
