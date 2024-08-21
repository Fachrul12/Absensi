@extends('layouts.main')

@section('content')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Edit isi kategori peserta</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active"><a href="#">Home</a></li>
            <li class="breadcrumb-item active"><a href="/event">Event</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('isikategoripesertas.index', ['kategoripesertaId' => $isikategoripeserta->kategori_peserta_id]) }}">Isi Kategori Peserta</a></li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
    <hr class="m-0">
</div>

<div class="card card-primary ml-3 mr-3">
  <div class="card-header text-white"" style="background-color: #4a525a ;">
        <h3 class="card-title">Form Edit isi kategori peserta</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
  <form action="{{ route('isikategoripesertas.update', $isikategoripeserta->id) }}" method="post" enctype="multipart/form-data">
      @csrf
      @method('PUT')
    <div class="card-body">
        <div class="form-group">
            <label for="nama_isi_kategori_peserta">Nama isi kategori peserta</label>
            <input type="text" class="form-control" id="nama_isi_kategori_peserta" name="nama_isi_kategori_peserta" placeholder="Masukkan Nama" value="{{ $isikategoripeserta->nama_isi_kategori_peserta }}">
        </div>

        <input type="hidden" name="kategoripesertaId" value="{{ $isikategoripeserta->kategori_peserta_id }}" readonly>

    </div>
      <!-- /.card-body -->
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Update</button>
    </div>
  </form>
</div>

@endsection
