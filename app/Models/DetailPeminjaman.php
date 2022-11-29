<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class DetailPeminjaman extends Pivot
{
    protected $table = 'detail_transaksi';

    protected $fillable = ['barang_id', 'transaksi_id', 'jumlah', 'kondisi', 'keterangan'];
    


}
