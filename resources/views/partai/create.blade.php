@extends('layouts.main')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Tambah Partai</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Tambah Partai</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
    <hr class="m-0">
  </div>

  <div class="card ml-3 mr-3">
    <div class="card-header">
      <h3 class="card-title">Form Tambah Partai</h3>      
    </div>
    <!-- /.card-header -->

    <div class="card-body">
      <form action="{{ route('partais.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="nama_partai">Nama Partai</label>
              <input type="text" class="form-control" id="nama_partai" name="nama_partai" required>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="bendera_partai">Bendera Partai</label>
              <input type="file" class="form-control-file" id="bendera_partai" name="bendera_partai" required>
            </div>
          </div>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Tambah Partai</button>
      </form>
    </div>
    <!-- /.card-body -->
  </div>

@endsection