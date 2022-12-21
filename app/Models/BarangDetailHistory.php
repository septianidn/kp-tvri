<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangDetailHistory extends Model
{
    use HasFactory;
    protected $table = 'barang_detail_history';
    protected $fillable = ['barang_detail_id', 'keterangan', 'jumlah', 'tanggal'];
}
