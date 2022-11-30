<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\mahasiswa;
use App\Models\Buku;

class PengembalianController extends Controller
{
    public function index(){
        return view('return.index');
    }

    public function getDataPeminjam($transaksi){
        return view('return.return', ['transaksi' => $transaksi]);
    }

    public function checkValidate(Request $request){
        $mahasiswa = mahasiswa::where('NIM', $request->nim)->first();
        $transaksi = Transaksi::where('nama_peminjam',$mahasiswa->Nama)->whereNull('tanggalPengembalian')->get();
        return $this->getDataTransaksi($transaksi, $mahasiswa);
    }

    public function pengembalian($transaksi){
        $transaksi = Transaksi::where('id', $transaksi)->first();
        $buku = Buku::where('namaBuku', '=' ,$transaksi->namaBuku)->first();
        $buku->jumlahBuku = $buku->jumlahBuku + $transaksi->jumlahBuku;
        $transaksi->tanggalPeminjaman = $transaksi->created_at;
        $transaksi->tanggalPengembalian = now();
        $buku->save();
        $transaksi->save();
        return redirect()->route('getIndexPengembalian')
                ->with('success_message', 'Berhasil Mengembalikan Buku');
    }

    public function getDataTransaksi($transaksi, $mahasiswa){
        if($transaksi == null){
            return redirect()->route('getIndexPengembalian')
                ->with('error_message', 'Mahasiswa '.$mahasiswa->nama.' Belum pernah meminjam');
        } else {
            return $this->getDataPeminjam($transaksi);
        }
    }
}