<?php

namespace App\Http\Controllers;

// Illuminate
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

// Model
use App\Models\Buku;
use App\Models\User;
use App\Models\Transaksi;
use App\Models\mahasiswa;
use Yajra\DataTables\DataTables;
use Exception;

class LendController extends Controller
{
    public function index(Request $request)
    {
        return view('lend.index');
    }

    public function lendBooksIndex($mahasiswa)
    {
        return view('lend.lendbooks', ['mahasiswa' => $mahasiswa]);
    }

    public function checkValidate(Request $request)
    {
        $mahasiswa = mahasiswa::where('NIM', $request->nim)->first();
        $transaksi = Transaksi::where('nama_peminjam', $mahasiswa->Nama)->whereNull('tanggalPengembalian')->first();
        return $this->checkDataTransaksi($transaksi, $mahasiswa);
    }

    public function insertLend($NIM, Request $request)
    {
        try {
            $buku = Buku::find($request->idBuku);
            $mahasiswa = mahasiswa::where('NIM', '=', $NIM)->first();
            $transaksi = Transaksi::where('nama_peminjam',$mahasiswa->Nama)->whereNull('tanggalPengembalian')->first();

            $this->checkJumlahBuku($buku->jumlahBuku, $request->pinjam);
            $transaksi = $this->checkTransaksiIsExist($transaksi);
            $this->insertTransaksi($transaksi, $request->pinjam, $mahasiswa->Nama, $buku->namaBuku);

            $buku->jumlahBuku = $buku->jumlahBuku - $request->pinjam;
            $buku->save();

            return redirect()->route('getIndexBorrows')
                ->with('success_message', 'Berhasil meminjam buku');
        } catch (Exception $e) {
            return redirect()->route('getIndexBorrows')
                ->with('error_message', $e->getMessage());
        }
    }

    public function checkJumlahBuku($jumlahBuku, $pinjam)
    {
        if ($jumlahBuku < $pinjam) {
            return redirect()->route('getLendBooks')
                ->with('error_message', 'Jumlah buku yang ada pada database sisa = ' . $jumlahBuku);
        }
    }

    public function checkTransaksiIsExist($transaksi)
    {
        if ($transaksi == null) {
            return $transaksi = new Transaksi();
        }
    }

    public function checkdataTransaksi($transaksi, $mahasiswa)
    {
        if ($transaksi != null) {
            if ($transaksi->jumlahBuku >= 2) {
                return redirect()->route('getIndexBorrows')->with('error_message', $transaksi->nama_peminjam . ' sudah tidak memiliki sisa untuk meminjam buku, harap untuk mengembalikan buku terlebih dahulu');
            } else {
                return $this->lendBooksIndex($mahasiswa);
            }
        } else if ($transaksi == null) {
            return $this->lendBooksIndex($mahasiswa);
        }
    }

    public function insertTransaksi($transaksi, $pinjam, $nama, $namaBuku)
    {
        $transaksi->nama_peminjam = $nama;
        $transaksi->namaBuku = $namaBuku;
        $transaksi->jumlahBuku = $transaksi->jumlahBuku + $pinjam;
        $transaksi->tanggalPeminjaman = now();
        $transaksi->save();
    }
}