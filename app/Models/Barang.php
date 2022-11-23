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
        return $this->belongsToMany(Peminjaman::class)->using(DetailPeminjaman::class);
    }
}
