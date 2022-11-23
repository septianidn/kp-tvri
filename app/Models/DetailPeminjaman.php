<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class DetailPeminjaman extends Pivot
{
    protected $table = 'barang_peminjaman';

    protected $fillable = ['barang_id', 'peminjaman_id', 'jumlah', 'kondisi', 'keterangan'];


}
