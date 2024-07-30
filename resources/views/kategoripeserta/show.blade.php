@extends('layouts.main')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-10">
                <h1 class="m-0">Event | {{ $kategoripesertas->nama_kategori_peserta }}</h1>
            </div><!-- /.col -->
            <div class="col-sm-2">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Event</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
    <hr class="m-0">
</div>

{{-- Button diatas table --}}
<div class="col-md-2">
    <div class="ml-2 mt-3">
        <a href="/isikategoripesertas/create/{{ $kategoripesertas->id }}" class="btn btn-success btn-sm w-100">
            Tambah <i class="fas fa-plus"></i>
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-3">
        <div class="mb-2 ml-3 mt-3">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Cari Event...">
                <div class="input-group-append">
                    <button class="btn btn-primary btn-sm" type="button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-2">
        <div class="mb-1 ml-1 mt-3">
            <a href="#" class="btn btn-success btn-sm w-10">
                Export Excel
            </a>
        </div>
    </div>

    <div class="">
        <div class="mb-1 mt-3">
            <a href="#" class="btn btn-primary btn-sm w-10">
                Export
            </a>
        </div>
    </div>
</div>

<div class="card ml-3 mr-3">
    <div class="card-header">
        <h3 class="card-title">List isi kategori peserta</h3>      
    </div>
    <!-- /.card-header -->

    <div class="card-body p-0">      
        <table class="table table-condensed table-striped">
            <thead>
                <tr>
                    <th style="width: 10px">No</th>            
                    <th>Nama</th>            
                    <th style="width: 19%"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($isikategoripesertas as $isikategoripeserta)
                <tr>
                    <td>{{ $loop->iteration }}</td>            
                    <td>{{ $isikategoripeserta->nama_isi_kategori_peserta }}</td>
                    <td class="project-actions text-right">
                        <div class="btn-group">
                            <a class="btn btn-primary btn-sm" href="{{ url('/generate-qr-code/'.$isikategoripeserta->id) }}">
                                <i class="fas fa-folder"></i>
                                View
                            </a>  
                            {{-- <a class="btn btn-info btn-sm" href="{{ route('isikategoripesertas.edit', $isikategoripeserta->id) }}">
                                <i class="fas fa-pencil-alt"></i>
                                Edit
                            </a>
                            <form action="{{ route('isikategoripesertas.destroy', $isikategoripeserta->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i>
                                    Delete
                                </button>
                            </form> --}}
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
</div>

@endsection
