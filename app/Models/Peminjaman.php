<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;
    protected $table = 'peminjaman';

    protected $fillable = ['id_peminjam', 'tanggal_pengembalian', 'tanggal_peminjaman', 'status_peminjaman', 'jumlah_barang', 'acara', 'lokasi'];

    public function barang(){
        return $this->belongsToMany(Barang::class)->using(DetailPeminjaman::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
