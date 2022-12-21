<?php

namespace App\Http\Controllers;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Barang;
use App\Models\BarangDetail;
use App\Models\BarangDetailHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $barang = Barang::select('barang.nama_barang', 'barang.id', 'barang.merk','barang.jenis')->selectRaw( 'GROUP_CONCAT(barang_detail.jumlah SEPARATOR "pcs ; ") as jumlah')->join('barang_detail', 'barang.id' ,'=', 'barang_detail.barang_id')->whereIn('barang_detail.keterangan', ['Baik', 'Rusak', 'Hilang'])->groupBy('nama_barang', 'barang.id', 'barang.merk', 'barang.jenis')->get();
        return view('barang.index', compact('barang'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function read()
    {
        $barang = Barang::select('barang.nama_barang', 'barang.id', 'barang.merk','barang.jenis')->selectRaw( 'GROUP_CONCAT(barang_detail.jumlah SEPARATOR "pcs ; ") as jumlah')->join('barang_detail', 'barang.id' ,'=', 'barang_detail.barang_id')->whereIn('barang_detail.keterangan', ['Baik', 'Rusak', 'Hilang'])->groupBy('nama_barang', 'barang.id', 'barang.merk', 'barang.jenis')->get();
        return view('barang.read', compact('barang'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function get(){
        $data = Barang::select('barang.nama_barang', 'barang.id', 'barang.merk','barang.jenis')->selectRaw( 'GROUP_CONCAT(barang_detail.jumlah SEPARATOR "pcs ; ") as jumlah')->join('barang_detail', 'barang.id' ,'=', 'barang_detail.barang_id')->whereIn('barang_detail.keterangan', ['Baik', 'Rusak', 'Hilang'])->groupBy('nama_barang', 'barang.id', 'barang.merk', 'barang.jenis')->get();

        return response()->json($data);
    }

   
    public function store(Request $request)
    {
       
        
        $validator = Validator::make($request->all(), [
            'nama_barang' => 'required|max:55',
            'jenis' => 'required|max:55',
            'merk' => 'required|max:55',
            'qty' => 'required',
        ]);

        if ($validator->fails()){
           return response()->json($validator->errors(), 422);
        }

       $data = Barang::create([
            'nama_barang'     => $request->nama_barang, 
            'jenis'   => $request->jenis,
            'merk'   => $request->merk,
        ]);

       
        $id = $data->id;
        $data->BarangDetail()->createMany([
            [
                'barang_id' => $id,
                'keterangan' => 'Baik',
                'jumlah' => $request->qty,
            ], 
            [
                'barang_id' => $id,
                'keterangan' => 'Rusak',
                'jumlah' => 0
            ], 
            [
                'barang_id' => $id,
                'keterangan' => 'Hilang',
                'jumlah' => 0
            ]
        ]);


        return response()->json([
    'success' => true,
    'message' => 'Data Berhasil Disimpan!',
    'data'    => $data  
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
        $data = Barang::select('barang.id', 'nama_barang', 'merk', 'jenis')->join('barang_detail', 'barang_detail.barang_id', '=', 'barang.id')->where('barang.id', '=', $id)->first();
        $data->baik = BarangDetail::where('barang_detail.barang_id', '=', $id)->where('keterangan', 'Baik')->first();
        $data->rusak = BarangDetail::where('barang_detail.barang_id', '=', $id)->where('keterangan', 'Rusak')->first();
        $data->hilang = BarangDetail::where('barang_detail.barang_id', '=', $id)->where('keterangan', 'Hilang')->first();
        
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Post',
            'data'    => $data  
        ]); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
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

        $barang = Barang::findOrFail($id);

        $oldBaik = BarangDetail::select('jumlah')->where('barang_id', $barang->id)->where('keterangan', 'Baik')->first();
        $oldRusak = BarangDetail::select('jumlah')->where('barang_id', $barang->id)->where('keterangan', 'Rusak')->first();
        $oldHilang = BarangDetail::select('jumlah')->where('barang_id', $barang->id)->where('keterangan', 'Hilang')->first();
        $perubahanBaik = 0;
        $perubahanRusak = 0;
        $perubahanHilang = 0;
        //define validation rules
        if($oldBaik == $request->baik) $perubahanBaik = $request->baik;
        else{
            $perubahanBaik = $oldBaik->jumlah-$request->baik;
        }

        if($oldRusak == $request->rusak) $perubahanRusak = $request->rusak;
        else{
            $perubahanRusak = $oldRusak->jumlah-$request->rusak;
        }
        
        if($oldHilang == $request->hilang) $perubahanHilang = $request->hilang;
        else{
            $perubahanHilang = $oldHilang->jumlah-$request->hilang;
        }
        $totalBarang = $oldBaik->jumlah + $oldRusak->jumlah + $oldHilang->jumlah;
        $totalUbah = $request->baik + $request->rusak + $request->hilang;

        $rules = array(
            'nama_barang'     => 'required',
            'jenis'   => 'required',
            'merk'   => 'required',
            'baik'   => 'required',
            'rusak'   => 'required',
            'hilang'   => 'required',
        );    
        $messages = array(
            'nama_barang.required' => 'Masukkan Nama Barang!',
            'jenis.required' => 'Masukkan Jenis Barang!',
            'merk.required' => 'Masukkan Merk Barang!.',
            'baik.required' => 'Masukkan Jumlah Barang Kondisi Baik!',
            'rusak.required' => 'Masukkan Jumlah Barang Kondisi Rusak!',
            'hilang.required' => 'Masukkan Jumlah Barang Kondisi Hilang!'
            
        );
        $validator = Validator::make($request->all(), $rules, $messages);

        if($totalBarang != $totalUbah){
            return response()->json([
                'message' => 'Jumlah barang tidak sama dengan jumlah awal!' 
            ],422);
        }
        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create post
        $barang->update([
            'nama_barang'     => $request->nama_barang, 
            'jenis'   => $request->jenis,
            'merk'   => $request->merk,
        ]);
        $keterangan = ['Baik', 'Rusak', 'Hilang'];
        $baik = BarangDetail::where('keterangan', 'Baik')->where('barang_id', $barang->id)->first();
        $baik->update(['jumlah' => $request->baik]);

        $rusak = BarangDetail::where('keterangan', 'Rusak')->where('barang_id', $barang->id)->first();
        $rusak->update(['jumlah' => $request->rusak]);
        $hilang = BarangDetail::where('keterangan', 'Hilang')->where('barang_id', $barang->id)->first();
        $hilang->update(['jumlah' => $request->hilang]);

        if($perubahanBaik !=0){
            $keterangan = "-";
            if($perubahanBaik>=1) $keterangan = "Mengurangi";
            else  $keterangan = "Menambah";
            $history = BarangDetailHistory::create([
                'barang_detail_id' => $baik->id,
                'keterangan' => $keterangan,
                'jumlah' => abs($perubahanBaik)
            ]);
        }
        
        if($perubahanRusak !=0){
            $keterangan = "-";
            if($perubahanRusak>=1) $keterangan = "Mengurangi";
            else  $keterangan = "Menambah";
            $history = BarangDetailHistory::create([
                'barang_detail_id' => $rusak->id,
                'keterangan' => $keterangan,
                'jumlah' => abs($perubahanRusak)
            ]);
        }
        if($perubahanHilang !=0){
            $keterangan = "-";
            if($perubahanHilang>=1) $keterangan = "Mengurangi";
            else  $keterangan = "Menambah";
            $history = BarangDetailHistory::create([
                'barang_detail_id' => $hilang->id,
                'keterangan' => $keterangan,
                'jumlah' => abs($perubahanHilang)
            ]);
        }

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Diudapte!',
            'data'    => $barang  
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Data Post Berhasil Dihapus!.',
        ]); 
    }
    
    public function history($id)
    {
        $barang = Barang::select('barang.nama_barang', 'barang_detail.keterangan as tipe', 'barang_detail_history.keterangan as keterangan' ,'barang_detail_history.tanggal', 'barang_detail_history.jumlah')->join('barang_detail', 'barang.id' , '=', 'barang_detail.barang_id')->join('barang_detail_history', 'barang_detail.id', '=', 'barang_detail_history.barang_detail_id')->where('barang.id', $id)->get();

        return view('barang.history', compact( 'barang'));
    }
}
