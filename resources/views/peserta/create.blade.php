@extends('layouts.main')
@section('content')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Tambah Peserta</h1>
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
    <div class="card-header">
        <h3 class="card-title">Form Peserta</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
  <form action="{{ route('pesertas.store') }}" method="post" enctype="multipart/form-data">
      @csrf
    <div class="card-body">
        <div class="form-group">
            <label for="nama_peserta">Nama Peserta</label>
            <input type="text" class="form-control" id="nama_peserta" name="nama_peserta" placeholder="Masukkan Nama">
        </div>
        <div class="form-group">
          <div class="row">
              <div class="col-sm-12">
                  <!-- select -->
                  <div class="form-group">
                      <label>Partai</label>
                      <select class="form-control" name="partai_id">
                          @foreach($partais as $partai)
                              <option value="{{ $partai->id }}">{{ $partai->nama_partai }}</option>
                          @endforeach
                      </select>
                  </div>
              </div>
          </div>
        </div>
      <div class="form-group">
        <div class="row">
            <div class="col-sm-12">
                <!-- select -->
                <div class="form-group">
                    <label>Pendukung Calon</label>
                    <select class="form-control" name="pendukung_calon_id">
                        @foreach($pendukung_calons as $calon)
                            <option value="{{ $calon->id }}">{{ $calon->nama_calon }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
      </div>
      <div class="form-group">
        <label for="foto_peserta">Foto Peserta</label>
        <div class="input-group">
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="foto_peserta" name="foto_peserta">
                <label class="custom-file-label" for="foto_peserta" id="file-label">Choose file</label>
            </div>
            <div class="input-group-append">
                <span class="input-group-text">Upload</span>
            </div>
        </div>
      </div>

    <input type="hidden" name="eventId" value="{{ $eventId }}" readonly>


      <!-- /.card-body -->

    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
  </form>
</div>
<script>
  document.getElementById('foto_peserta').addEventListener('change', function() {
      var fileName = this.files[0].name;
      document.getElementById('file-label').innerHTML = fileName;
  });
</script>

  @endsection
