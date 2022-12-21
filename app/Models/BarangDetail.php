<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangDetail extends Model
{
    use HasFactory;
    protected $table = 'barang_detail';
    protected $fillable = ['barang_id', 'keterangan', 'jumlah'];

    public function barang()
    {
        return $this->belongsTo(Barang::class,'barang_id','id');
    }
}
