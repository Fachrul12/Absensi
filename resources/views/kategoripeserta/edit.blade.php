@extends('layouts.main')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit Kategori Peserta</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Edit Kategori Peserta</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
    <hr class="m-0">
</div>

<div class="card ml-3 mr-3">
    <div class="card-header text-white"" style="background-color: #4a525a ;">
        <h3 class="card-title">Form Edit Kategori Peserta</h3>      
    </div>
    <!-- /.card-header -->

    <div class="card-body">
        <form action="{{ route('kategoripesertas.update', $kategoripeserta->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')            
                    <div class="form-group">
                        <label for="nama_kategori_peserta">Nama Kategori Peserta</label>
                        <input type="text" class="form-control" id="nama_kategori_peserta" name="nama_kategori_peserta" value="{{ $kategoripeserta->nama_kategori_peserta }}" required>
                    </div>               
            <button type="submit" class="btn btn-primary">Update Kategori Peserta</button>
        </form>
    </div>
    <!-- /.card-body -->
</div>

@endsection
