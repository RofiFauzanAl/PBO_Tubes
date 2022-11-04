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
            
        }
    }
}