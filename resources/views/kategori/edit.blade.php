@extends('layouts.main')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Edit kategori</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Edit kategori</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
    <hr class="m-0">
  </div>

  <div class="card ml-3 mr-3">
    <div class="card-header">
      <h3 class="card-title">Form Edit kategori</h3>      
    </div>
    <!-- /.card-header -->

    <div class="card-body">
      <form action="{{ route('kategoris.update', $kategori->id) }}" method="post">
        @csrf
        @method('PUT')
        <div class="form-group">
          <label for="nama_kategori">Nama kategori</label>
          <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" value="{{ $kategori->nama_kategori }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update kategori</button>
      </form>
    </div>
    <!-- /.card-body -->
  </div>

@endsection