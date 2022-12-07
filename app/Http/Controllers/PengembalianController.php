<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PeminjamanController;

class PengembalianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $barang = Barang::all();
        $pengembalian = Peminjaman::select('transaksi.id', 'transaksi.acara', 'transaksi.lokasi', 'users.name', 'transaksi.tanggal_pengembalian', 'transaksi.tanggal_peminjaman', 'transaksi.status_peminjaman', 'transaksi.jumlah_barang')->join('users', 'users.id' , '=', 'transaksi.id_peminjam')->where('users.id', Auth::user()->id)->where('transaksi.status_peminjaman', 'Dipinjam')->get();

        return view('pengembalian.index', compact('barang', 'pengembalian'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $detailPeminjaman = Peminjaman::findOrFail($request->transaksi_id);
        $jumlah = [];
        foreach($request->id_barang as $key => $barang){
               $jumlah[$barang] = ['jumlah' => $request->qty[$key], 'keterangan' => $request->kondisi[$key], 'jenis_transaksi' => 'pengembalian'];
               Barang::where('id', $barang)->increment('qty', $request->qty[$key]);
            }
            
            $detailPeminjaman->status_peminjaman = 'Dikembalikan';
            $detailPeminjaman->save();
            $detailPeminjaman->barang()->attach($jumlah);

        

       return response()->json(["message" => "Barang Berhasil dikembalikan!"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pengembalian = Peminjaman::select('transaksi.id as tid', 'barang.nama_barang', 'barang.id as bid', 'transaksi.acara', 'transaksi.lokasi', 'users.name', 'transaksi.tanggal_pengembalian', 'transaksi.tanggal_peminjaman', 'transaksi.status_peminjaman', 'detail_transaksi.jumlah')->join('users', 'users.id' , '=', 'transaksi.id_peminjam')->join('detail_transaksi', 'detail_transaksi.transaksi_id', '=', 'transaksi.id')->join('barang', 'barang.id', '=', 'detail_transaksi.barang_id')->where('users.id', Auth::user()->id)->where('transaksi.id', $id)->where('transaksi.status_peminjaman' , 'Dipinjam')->get();

        // $p = $pengembalian->barang;
        
        return view('pengembalian.kembali', compact('pengembalian'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
