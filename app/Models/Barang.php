<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $table = "barang";
    protected $fillable = ["nama_barang", "jenis", "merk", "qty", 'kondisi'];


    public function peminjaman(){
        return $this->belongsToMany(Peminjaman::class,'detail_transaksi','barang_id','transaksi_id')->as('detail_transaksi')->withPivot('jumlah','keterangan','jenis_transaksi');
    }
}
