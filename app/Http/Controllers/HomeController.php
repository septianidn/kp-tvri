<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function get()
    {
        $peminjaman = Peminjaman::select(DB::raw("(COUNT(*)) as count"),DB::raw("MONTHNAME(tanggal_peminjaman) as monthname"),DB::raw("YEAR(tanggal_peminjaman) as year"),DB::raw("Month(tanggal_peminjaman) as month"))->whereYear('tanggal_peminjaman', date('Y'))->groupBy('monthname', 'year', 'month')->orderBy('month')->get();

        $pie = Peminjaman::select(DB::raw("(COUNT(*)) as count"),DB::raw("status_peminjaman as status"))->whereYear('tanggal_peminjaman', date('Y'))->groupBy('status')->get();

        return response()->json([
            $peminjaman,
            $pie
        ]);
    }
}
