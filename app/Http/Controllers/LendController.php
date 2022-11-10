<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Buku;
use App\Models\User;
use App\Models\Transaksi;
use Exception;

class LendController extends Controller
{
    public function index()
    {
        $buku = Buku::all();
        return view('lend.lendbooks', [
            'buku' => $buku
        ]);
    }

    public function update($id, $userid)
    {
        try{
            //  Take Data
            $buku = Buku::find($id);
            // dd($buku);
            $user = User::find($userid);
            // dd($user);
            $buku->jumlahBuku = $buku->jumlahBuku - 1;

            // Transaksi
            $transaksiDB = DB::table('transaksis')->where('nama_peminjam', $user->name);
            $transaksi = new Transaksi();
            $transaksi->nama_peminjam = $user->name; 
            $transaksi->namaBuku = $buku->namaBuku;
            $transaksi->jumlahBuku = $transaksi->jumlahBuku + 1;
            // $transaksi->tanggalPeminjaman = now();
            $transaksi->save();
            $buku->save();

            return redirect()->route('getIndexBorrows')
                ->with('success_message', 'Berhasil meminjam buku');
            
            
        }
        catch(Exception $e){
            return redirect()->route('getIndexBorrows')->with('error_message', $e->getMessage());
        }
    }
}