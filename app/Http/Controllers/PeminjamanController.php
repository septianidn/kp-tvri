<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\DetailPeminjaman;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class PeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $barang = Barang::all();
        $peminjaman = Peminjaman::select('transaksi.id', 'transaksi.acara', 'transaksi.lokasi', 'users.name', 'transaksi.tanggal_pengembalian', 'transaksi.tanggal_peminjaman', 'transaksi.status_peminjaman', 'transaksi.jumlah_barang')->join('users', 'users.id' , '=', 'transaksi.id_peminjam')->get();

        return view('peminjaman.index', compact('barang', 'peminjaman'));
    }

    public function get(){
       $peminjaman = Peminjaman::select('transaksi.id', 'transaksi.acara', 'transaksi.lokasi', 'users.name', 'transaksi.tanggal_pengembalian', 'transaksi.tanggal_peminjaman', 'transaksi.status_peminjaman', 'transaksi.jumlah_barang')->join('users', 'users.id' , '=', 'transaksi.id_peminjam')->get();

        return response()->json($peminjaman);
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
        // $jumlah=0;
        // foreach($request->qty as $qty){
        //     $jumlah += $qty;
        // }
        // return response()->json($jumlah,422);
        
         

        $rules = array(
            'tanggal' => 'required|date',
            'acara' => 'required|max:50',
            'lokasi' => 'required|max:50',
            'nama_barang' => 'required|min:1',
            'nama_barang.*' => 'distinct|min:1',
            'qty.*' => 'min:1',
            'qty' => 'required|min:1',
        );    
        $messages = array(
            'acara.required' => 'Masukkan Acara!',
            'lokasi.required' => 'Masukkan Lokasi!',
            'nama_barang' => 'Silahkan Pilih Item yang akan dipinjam!.',
            'nama_barang.*.distinct' => 'Silahkan Pilih Item yang Berbeda!.',
            'nama_barang.*.min' => 'Silahkan Pilih Item yang akan dipinjam!.',
            'qty.*.min' => 'Masukkan Jumlah unit yang akan dipinjam!.',
            'tanggal.required' => 'Masukkan Tanggal!' 
            
        );
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()){
           return response()->json($validator->errors(), 422);
        }
        foreach ($request->qty as $key => $brg) {
            $qty = $brg;
            $stok = Barang::select('barang.qty','barang.nama_barang')->where('id', '=', $request->nama_barang[$key])->first();
            
            if(!$stok->exists()){
                return response()->json([
                'message' => 'Jumlah barang'.$stok->nama_barang.' kosong!' 
            ],422);
            }
            
            if($stok->qty == 0){
                return response()->json([
                'message' => 'Jumlah barang '.$stok->nama_barang.' Kosong!' 
            ],422);
            }
            if($request->qty[$key] > $stok->qty){
                
                return response()->json([
                'message' => 'Jumlah barang '.$stok->nama_barang.' tidak mencukupi!' 
            ],422);
            }
        }
        $user = Auth::user();

        
        $peminjaman = Peminjaman::create([
            'id_peminjam' => $user->id,
            'tanggal_pengembalian' => $request->tanggal,
            'acara' => $request->acara,
            'lokasi' => $request->lokasi,
            'tanggal_peminjaman' => date('Y-m-d'),
            'jumlah_barang' => $request->jumlah,
            'status_peminjaman' => 'Dipinjam'
        ]);

        


        $detailPeminjaman = Peminjaman::latest()->first();
        $jumlah = [];
        foreach($request->nama_barang as $key => $barang){
               $jumlah[$barang] = ['jumlah' => $request->qty[$key], 'keterangan' => '-'];
               Barang::where('id', $barang)->decrement('qty', $request->qty[$key]);
            }
            $detailPeminjaman->barang()->attach($jumlah);

        

       return response()->json([
    'success' => true,
    'message' => 'Data Berhasil Disimpan!',
    'data' => $peminjaman
]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $peminjaman = Peminjaman::select('transaksi.id', 'transaksi.acara', 'transaksi.lokasi','transaksi.tanggal_pengembalian', 'transaksi.tanggal_peminjaman', 'barang.nama_barang', 'barang.merk', 'detail_transaksi.keterangan', 'barang.kondisi', 'users.name', 'detail_transaksi.jumlah')->join('users', 'users.id', '=', 'transaksi.id_peminjam')->join('detail_transaksi', 'transaksi.id', '=', 'detail_transaksi.transaksi_id')->join('barang' , 'barang.id', '=', 'detail_transaksi.barang_id')->get();

        return view('peminjaman.cetak', compact('peminjaman'));
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
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->barang()->detach();
        $peminjaman->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Data Post Berhasil Dihapus!.',
        ]); 
    }
}
