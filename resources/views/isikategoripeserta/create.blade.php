@extends('layouts.main')
@section('content')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Tambah isi kategori peserta nnn</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active"><a href="#">Home</a></li>
            <li class="breadcrumb-item active"><a href="/event">Event</a></li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
    <hr class="m-0">
</div>

<div class="card card-primary ml-3 mr-3">
  <div class="card-header text-white"" style="background-color: #4a525a ;">
        <h3 class="card-title">Form isi kategori peserta</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
  <form action="{{ route('kategoripesertas.isikategoripesertas.store', ['kategoripeserta' => $kategoripesertaId]) }}" method="post" enctype="multipart/form-data">
      @csrf
    <div class="card-body">
        <div class="form-group">
            <label for="nama_isi_kategori_peserta">Nama isi kategori peserta</label>
            <input type="text" class="form-control" id="nama_isi_kategori_peserta" name="nama_isi_kategori_peserta" placeholder="Masukkan Nama">
        </div>

        <input type="hidden" name="kategoripesertaId" value="{{ $kategoripesertaId }}" readonly>

    </div>
      <!-- /.card-body -->
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
  </form>
</div>


  @endsection
