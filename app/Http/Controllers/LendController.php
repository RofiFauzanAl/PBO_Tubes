<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Buku;
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

    public function update($id)
    {
        try{
            $buku = Buku::find($id);
            $buku->jumlahBuku = $buku->jumlahBuku - 1;
            $buku->save();
            return redirect()->route('getIndex')
                ->with('success_message', 'Berhasil meminjam buku');
                            
        }
        catch(Exception $e){
            Log::error($e->getMessage(), "ERROR saat peminjaman buku");
            return redirect()->route('books.index')
            ->with('error_message','Error');
        }
    }
}