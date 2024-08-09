@extends('layouts.main')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-9">
                <h1 class="m-0">Acara | {{ $event->nama_event }}</h1>
            </div><!-- /.col -->
            <div class="col-sm-3">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="/events">List Peserta</a></li>
                    <li class="breadcrumb-item active">Daftar Peserta</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
    <hr class="m-0">
</div>

{{-- Button diatas table --}}
<div class="col-md-2">
    <div class=" ml-2 mt-3">
        <a href="/pesertas/create/{{ $event->id }}" class="btn btn-success btn-sm w-100">
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
            <a href="/import-peserta/{{ $event->id  }}" class="btn btn-success btn-sm w-10">
                Import Excel
            </a>
        </div>
    </div>

    <div class="">
        <div class="mb-1 mt-3">
            <a href="{{ route('export.pesertas') }}" class="btn btn-success btn-sm w-10">
                Export Excel
            </a>
            
        </div>
    </div>
</div>


<div class="card ml-3 mr-3">
    <div class="card-header">
        <h3 class="card-title">List Peserta</h3>      
    </div>
    <!-- /.card-header -->

    <div class="card-body p-0">
        <table class="table table-condensed table-striped">
            <thead>
                <tr>
                    <th style="width: 10px">No</th>
                    <th>Foto</th>
                    <th>Nama</th>
                    <th>Kategori</th>                               
                    <th style="width: 19%"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($pesertas as $peserta)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <img src="{{ asset('storage/foto_peserta/'. $peserta->foto_peserta) }}" alt="foto-peserta" width="30" height="30" class="img-fluid rounded">
                    </td>            
                    <td>{{ $peserta->nama_peserta }}</td>
                    <td>
                        {{
                            optional($peserta->isiKategoriPeserta->kategoriPeserta)->nama_kategori_peserta
                            ? optional($peserta->isiKategoriPeserta->kategoriPeserta)->nama_kategori_peserta . ' - ' . $peserta->isiKategoriPeserta->nama_isi_kategori_peserta
                            : 'N/A'
                        }}
                    </td>               
                    <td class="project-actions text-right">
                        <div class="btn-group">
                            <a class="btn btn-primary btn-sm" href="{{ url('/generate-qr-code/'.$peserta->id) }}">
                                <i class="fas fa-folder"></i>
                                View
                            </a>  
                            <a class="btn btn-info btn-sm" href="{{ route('pesertas.edit', $peserta->id) }}">
                                <i class="fas fa-pencil-alt"></i>
                                Edit
                            </a>
                            <form action="{{ route('pesertas.destroy', $peserta->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i>
                                    Delete
                                </button>
                            </form>
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