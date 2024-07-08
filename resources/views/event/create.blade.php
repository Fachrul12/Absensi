@extends('layouts.main')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Tambah Event</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Tambah Event</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
    <hr class="m-0">
  </div>

  <div class="card ml-3 mr-3">
    <div class="card-header">
      <h3 class="card-title">Form Tambah Event</h3>      
    </div>
    <!-- /.card-header -->

    <div class="card-body">
      <form action="{{ route('events.store') }}" method="post">
        @csrf
        <div class="form-group">
          <label for="nama_event">Nama Event</label>
          <input type="text" class="form-control" id="nama_event" name="nama_event" required>
        </div>
        
        <div class="form-group">
            <div class="row">
                <div class="col-sm-12">
                  <!-- select -->
                    <div class="form-group">
                    <label>Kategori Event</label>
                    <select class="form-control" name="kategori_id">
                        <option value=""> - </option>
                        @foreach ($kategoris as $kategori)
                            <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                        @endforeach
                    </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
          <label for="tanggal_acara">Tanggal Acara</label>
          <input type="date" class="form-control" id="tanggal_acara" name="tanggal_acara" required>
        </div>
        <button type="submit" class="btn btn-primary">Tambah Event</button>
      </form>
    </div>
    <!-- /.card-body -->
  </div>

@endsection