<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   $barang = Barang::all();
        $peminjaman = Peminjaman::where('status_peminjaman', 'Dipinjam');
        $pengembalian = Peminjaman::where('status_peminjaman', 'Dikembalikan');
        return view('dashboard.index',compact('barang', 'peminjaman', 'pengembalian'));
    }
}
