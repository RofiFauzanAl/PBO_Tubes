<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class BookController extends Controller
{
    public function index(){
        $buku = Buku::all();
        return view('books.indexbooks', [
            'buku' => $buku
        ]);
    }

    public function create()
    {
        return view('books.insertbooks');
    }
    
    public function store(Request $request){
        try{
            $buku = new Buku();
            $buku->namaBuku = $request->input('namaBuku');
            $buku->author = $request->input('author');
            $buku->genreBuku = $request->input('genreBuku');
            $buku->jumlahBuku = $request->input('jumlahBuku');
            $buku->save();
            return redirect()->route('books.index')
            ->with('success_message','Buku Ditambahkan.');
        } catch (Exception $e){
            Log::error($e->getMessage());
            return redirect()->route('books.index')
            ->with('error_message','Error ketika menambahkan');
        } 
    }

    public function edit($id)
    {
        $buku = Buku::find($id);
        if (!$buku) return redirect()->route('books.index')
            ->with('error_message', 'User dengan id '.$id.' tidak ditemukan');
        return view('books.updatebooks', [
            'buku' => $buku
        ]);
    }
    

    public function update(Request $request, $id)
    {
        $buku = Buku::find($id);
        $buku->namaBuku = $request->input('namaBuku');
        $buku->author = $request->input('author');
        $buku->genreBuku = $request->input('genreBuku');
        $buku->save();
        return redirect()->route('books.index')
            ->with('success_message', 'Berhasil mengubah Buku');
    }
    
    public function destroy($id)
    {
        $buku = Buku::find($id);
        if ($buku) $buku->delete();
        return redirect()->route('books.index')
            ->with('success_message', 'Berhasil menghapus buku');
    }
}