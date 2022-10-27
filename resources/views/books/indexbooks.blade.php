@extends('adminlte::page')

@section('title', 'List User')

@section('content_header')
    <h1 class="m-0 text-dark">List Buku</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <a href="{{route('books.create')}}" class="btn btn-primary mb-2">
                        Tambah Buku
                    </a>

                    <table class="table table-hover table-bordered table-stripped" id="example2">
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Buku</th>
                            <th>Author</th>
                            <th>Genre Buku</th>
                            <th>Jumlah Buku</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($buku as $key => $buk)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$buk->namaBuku}}</td>
                                <td>{{$buk->author}}</td>
                                <td>{{$buk->genreBuku}}</td>
                                <td>{{$buk->jumlahBuku}}</td>
                                <td>
                                    <a href="{{route('books.edit', $buk)}}" class="btn btn-primary btn-xs">
                                        Edit
                                    </a>
                                    <a href="{{route('books.destroy', $buk)}}" onclick="notificationBeforeDelete(event, this)" class="btn btn-danger btn-xs">
                                        Delete
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
@stop

@push('js')
    <form action="" id="delete-form" method="post">
        @method('delete')
        @csrf
    </form>
    <script>
        $('#example2').DataTable({
            "responsive": true,
        });

        function notificationBeforeDelete(event, el) {
            event.preventDefault();
            if (confirm('Apakah anda yakin akan menghapus data ? ')) {
                $("#delete-form").attr('action', $(el).attr('href'));
                $("#delete-form").submit();
            }
        }

    </script>
@endpush
