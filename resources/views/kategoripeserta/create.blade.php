@extends('layouts.main')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Tambah kategori peserta</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Tambah kategori peserta</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
    <hr class="m-0">
  </div>

  <div class="card ml-3 mr-3">
    <div class="card-header">
      <h3 class="card-title">Form Tambah kategori peserta</h3>      
    </div>
    <!-- /.card-header -->

    <div class="card-body">
      <form action="{{ route('kategoripesertas.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="nama_kategori_peserta">Nama kategori peserta</label>
              <input type="text" class="form-control" id="nama_kategori_peserta" name="nama_kategori_peserta" required>
            </div>
          </div>          
        </div>
        <button type="submit" class="btn btn-primary btn-block">Tambah kategori peserta</button>
      </form>
    </div>
    <!-- /.card-body -->
  </div>

@endsection