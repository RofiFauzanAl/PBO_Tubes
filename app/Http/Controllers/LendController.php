<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;

class LendController extends Controller
{
    public function index()
    {
        $buku = Buku::all();
        return view('lend.lendbooks', [
            'buku' => $buku
        ]);
    }
    
    public function pinjam(Request $request,$id)
    {
        $buku = Buku::find($id)->decrement($request->input('jumlahBuku'));
        $buku->save();
        return redirect()->route('books.index')
            ->with('success_message', 'Berhasil menghapus buku');
    }
}