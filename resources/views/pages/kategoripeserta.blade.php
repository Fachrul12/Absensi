@extends('layouts.main')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Kategori Pesertas</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Kategori Pesertas</li>
                </ol>
            </div>
        </div>
    </div>
    <hr class="m-0">
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<!-- Button and Search Bar -->
<div class="col-md-2">
    <div class="mb-3 ml-2 mt-3">
        <a href="{{ route('kategoripesertas.create') }}" class="btn btn-success btn-sm w-100">
            <i class="fas fa-plus"></i> Tambah 
        </a>        
    </div>    
</div>

<!-- List Kategori Peserta -->
<div class="card ml-3">
    <div class="card-header text-white"" style="background-color: #4a525a ;">
        <h3 class="card-title">List Kategori Peserta</h3>
        <div class="card-tools">
            <div class="input-group input-group-sm" style="width: 150px;">
              <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
              <div class="input-group-append">
                <button type="submit" class="btn btn-default">
                  <i class="fas fa-search"></i>
                </button>
              </div>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <table class="table table-condensed table-striped">
            <thead>
                <tr>
                    <th style="width: 10px">No</th>                    
                    <th>Nama Kategori Peserta</th>
                    <th style="width: 19%"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($kategoripesertas as $kategoripeserta)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $kategoripeserta->nama_kategori_peserta }}</td>                    
                    <td class="project-actions text-right">
                        <div class="btn-group">
                        <a class="btn btn-primary btn-sm" href="{{ route('kategoripesertas.show', $kategoripeserta->id) }}">
                            <i class="fas fa-eye"></i>
                            Lihat
                        </a>
                        <a class="btn btn-info btn-sm mr-1 ml-1" href="{{ route('kategoripesertas.edit', $kategoripeserta->id) }}">
                            <i class="fas fa-pencil-alt"></i>
                            Edit
                        </a>
                        <button class="btn btn-danger btn-sm" data-id="{{ $kategoripeserta->id }}" onclick="confirmDelete(this)">
                            <i class="fas fa-trash"></i>
                            Delete
                        </button>
                        <form id="delete-kategoripeserta-{{ $kategoripeserta->id }}" action="{{ route('kategoripesertas.destroy', $kategoripeserta->id) }}" method="post" style="display: none;">
                            @csrf
                            @method('DELETE')                            
                        </form> 
                    </div>                   
                    </td>                    
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    function confirmDelete(button) {
        const id = button.getAttribute('data-id');
        const form = document.getElementById(`delete-kategoripeserta-${id}`);

        if (confirm('Apakah Anda yakin ingin menghapus kategori ini?')) {
            form.submit();
        }
    }
</script>

@endsection
