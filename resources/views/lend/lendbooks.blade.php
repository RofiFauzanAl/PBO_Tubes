@extends('adminlte::page')

@section('title', 'List Buku')

@section('content_header')
    <h1 class="m-0 text-dark">List Buku Pinjam</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
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
                                    <form action="{{route('setUpdate', $buk)}}" method="post">
                                        @method('PUT')
                                        @csrf
                                        <button type="submit" class="btn btn-primary">Pinjam</button>
                                    </form>
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
