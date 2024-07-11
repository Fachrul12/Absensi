@extends('layouts.main')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Edit Partai</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Edit Partai</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
    <hr class="m-0">
  </div>

  <div class="card ml-3 mr-3">
    <div class="card-header">
      <h3 class="card-title">Form Edit Partai</h3>      
    </div>
    <!-- /.card-header -->

    <div class="card-body">
      <form action="{{ route('partais.update', $partai->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="nama_partai">Nama Partai</label>
              <input type="text" class="form-control" id="nama_partai" name="nama_partai" value="{{ $partai->nama_partai }}" required>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="bendera_partai">Bendera Partai</label>
              <div class="input-group">
                <img src="{{ asset('storage/partai/' . $partai->bendera_partai) }}" alt="Bendera Partai" width="50" height="50" class="mr-2">
                <input type="file" class="form-control-file" id="bendera_partai" name="bendera_partai">
              </div>
            </div>
          </div>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Update Partai</button>
      </form>
    </div>
    <!-- /.card-body -->
  </div>

@endsection