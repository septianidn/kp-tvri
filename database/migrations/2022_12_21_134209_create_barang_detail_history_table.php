<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangDetailHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang_detail_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('barang_detail_id'); 
            $table->string('keterangan')->default('-'); 
            $table->integer('jumlah'); 
            $table->timestamp('tanggal')->useCurrent();
            $table->timestamps();
            $table->foreign('barang_detail_id')->references('id')->on('barang_detail')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barang_detail_history');
    }
}
