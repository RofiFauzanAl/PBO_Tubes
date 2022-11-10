<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;
use Exception;
// use Yajra\DataTables\Contracts\DataTable;

class BookController extends Controller
{
    public function index(Request $request)
    {
        // $buku = Buku::all();
        // return view('books.indexbooks', [
        //     'buku' => $buku
        // ]);
        if ($request->ajax()) {
            $buku = Buku::select('*');
            return DataTables::of($buku)
                ->addIndexColumn()
                ->addColumn('action', function ($row){
                    $btn = '<a href= "' . route('books.edit', $row->id) . '" class="btn btn-primary btn-xs">Edit</a>';
                    $btn = $btn . ' <a href="' 
                                . route('books.destroy', $row->id)
                                . '"class="btn btn-danger btn-xs" onclick="notificationBeforeDelete(event, this)">Hapus</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }        
        return view('books.indexbooks');
    }

    public function create()
    {
        return view('books.insertbooks');
    }
    
    public function store(Request $request){
        try{
            $buku = new Buku();
            $data = [
                $namaBuku = $request->input('namaBuku'),
                $author = $request->input('author'),
                $genreBuku = $request->input('genreBuku'),
                $jumlahBuku = $request->input('jumlahBuku')
            ];
            $buku->namaBuku = $data[0];
            $buku->author = $data[1];
            $buku->genreBuku = $data[2];
            $buku->jumlahBuku = $data[3];
            if($data[3] <= 0){
                return redirect()->route('books.create', [
                    'buku' => $buku
                ])
                    ->with('error_message','Error karena jumlah buku tidak bisa negatif');
            }
            $buku->save();
            return redirect()->route('books.index')
            ->with('success_message','Buku Ditambahkan.');
        } catch (Exception $e){
            Log::error($e->getMessage(), "Error pada user ketika menambahkan buku");
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