<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Peminjaman;
use App\Models\BarangDetail;
use Illuminate\Http\Request;
use App\Models\DetailPeminjaman;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class PeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public static function peminjaman(){
        $barang = Barang::all();
        $peminjaman = Peminjaman::select('transaksi.id', 'transaksi.acara', 'transaksi.lokasi', 'users.name', 'transaksi.tanggal_pengembalian', 'transaksi.tanggal_peminjaman', 'transaksi.status_peminjaman', 'transaksi.jumlah_barang')->join('users', 'users.id' , '=', 'transaksi.id_peminjam')->get();

        return view('peminjaman.index', compact('barang', 'peminjaman'));
    }
    public function index()
    {
        return $this->peminjaman();
    }

    public function history()
    {
        $peminjaman = Peminjaman::select('transaksi.id', 'transaksi.acara', 'transaksi.lokasi', 'users.name', 'transaksi.tanggal_pengembalian', 'transaksi.tanggal_peminjaman', 'transaksi.status_peminjaman', 'transaksi.jumlah_barang')->join('users', 'users.id' , '=', 'transaksi.id_peminjam')->where('users.id', Auth::user()->id)->get();

        return view('peminjaman.history', compact( 'peminjaman'));
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
        
         
        
        if((time()-(60*60*24)) > strtotime($request->tanggal)){
            return response()->json([
                'message' => 'Tanggal tidak boleh sebelum tanggal sekarang!' 
            ],422);
        }
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
            $stok = BarangDetail::select('barang_detail.jumlah','barang.nama_barang')->where('barang.id', '=', $request->nama_barang[$key])->where('keterangan' , 'Baik')->join('barang', 'barang.id' , '=', 'barang_detail.barang_id')->first();
            
            if(!$stok->exists()){
                return response()->json([
                'message' => 'Jumlah barang'.$stok->nama_barang.' kosong!' 
            ],422);
            }
            
            if($stok->jumlah == 0){
                return response()->json([
                'message' => 'Jumlah barang '.$stok->nama_barang.' Kosong!' 
            ],422);
            }
            if($request->qty[$key] > $stok->jumlah){
                
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
               BarangDetail::where('barang_id', $barang)->where('keterangan', 'Baik')->decrement('jumlah', $request->qty[$key]);
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
        $peminjaman = Peminjaman::select('transaksi.id', 'transaksi.acara', 'transaksi.lokasi','transaksi.tanggal_pengembalian', 'transaksi.tanggal_peminjaman', 'barang.nama_barang', 'barang.merk', 'detail_transaksi.keterangan',  'users.name', 'detail_transaksi.jumlah')->join('users', 'users.id', '=', 'transaksi.id_peminjam')->join('detail_transaksi', 'transaksi.id', '=', 'detail_transaksi.transaksi_id')->join('barang' , 'barang.id', '=', 'detail_transaksi.barang_id')->where('users.id', Auth::user()->id)->where('status_peminjaman', 'Dipinjam')->where('transaksi.id', $id)->get();
        
        if (count($peminjaman)==0){
            return response()->json([
            'success' => false,
            'message' => 'Tidak dapat mencetak!'
        ], 404); 
        }

        return view('peminjaman.cetak', compact('peminjaman'));
    }
    public function cetak($id)
    {
        $peminjaman = Peminjaman::select('transaksi.id', 'transaksi.acara', 'transaksi.lokasi','transaksi.tanggal_pengembalian', 'transaksi.tanggal_peminjaman', 'barang.nama_barang', 'barang.merk', 'detail_transaksi.keterangan', 'barang.kondisi', 'users.name', 'detail_transaksi.jumlah')->join('users', 'users.id', '=', 'transaksi.id_peminjam')->join('detail_transaksi', 'transaksi.id', '=', 'detail_transaksi.transaksi_id')->join('barang' , 'barang.id', '=', 'detail_transaksi.barang_id')->where('users.id', Auth::user()->id)->where('status_peminjaman', 'Dipinjam')->where('transaksi.id', $id)->get();

        if (count($peminjaman)==0){
            return response()->json([
            'success' => false,
            'message' => 'Tidak dapat mencetak!'
        ], 404); 
        }

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
        $barang = $peminjaman->barang[0];
        $jumlah =  $peminjaman->barang[0]->detail_transaksi->jumlah;
        BarangDetail::where('barang_id', $barang->id)->where('keterangan', 'Baik')->increment('jumlah', $jumlah);
        $peminjaman->barang()->detach();
        $peminjaman->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Data Post Berhasil Dihapus!.',
        ]); 
    }
}
