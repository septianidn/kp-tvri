<?php

namespace App\Http\Controllers;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Barang;
use Illuminate\Http\Request;use 
Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $barang = Barang::all();
        return view('barang.index', compact('barang'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function read()
    {
        $barang = Barang::all();
        return view('barang.read', compact('barang'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function get(){
        $data = Barang::all();

        return response()->json($data);
    }
    public function store(Request $request)
    {
        
        
        // $validated = $request->validate( [
        //     'nama_barang' => 'required|max:55',
        //     'jenis' => 'required|max:55',
        //     'merk' => 'required|max:55',
        //     'qty' => 'required',
        // ]);

        
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
            'qty'   => $request->qty,
        ]);
        
        // $data = new Barang();
        // $data->nama_barang = $validated['nama'];
        // $data->jenis = $validated['jenis'];
        // $data->merk = $validated['merk'];
        // $data->qty = $validated['jumlah'];
        // $data->save();

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
        $data = Barang::findOrFail($id);

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

        //define validation rules
        $validator = Validator::make($request->all(), [
            'nama_barang'     => 'required',
            'jenis'   => 'required',
            'merk'   => 'required',
            'qty'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create post
        $barang->update([
            'nama_barang'     => $request->nama_barang, 
            'jenis'   => $request->jenis,
            'merk'   => $request->merk,
            'qty'   => $request->qty
        ]);

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
}
