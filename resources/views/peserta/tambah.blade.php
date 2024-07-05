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
<form>
    <div class="card-body">
        <div class="form-group">
            <label for="nama_peserta">Nama Peserta</label>
            <input type="text" class="form-control" id="nama_peserta" placeholder="Masukkan Nama">
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col-sm-12">
                  <!-- select -->
                    <div class="form-group">
                    <label>Partai</label>
                    <select class="form-control">
                        <option> - </option>
                        <option>option 1</option>
                        <option>option 2</option>
                        <option>option 3</option>
                        <option>option 4</option>
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
                    <select class="form-control">
                        <option> - </option>
                        <option>option 1</option>
                        <option>option 2</option>
                        <option>option 3</option>
                        <option>option 4</option>
                    </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="foto_peserta">Foto Peserta</label>
            <div class="input-group">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="foto_peserta">
                    <label class="custom-file-label" for="foto_peserta">Choose file</label>
                </div>
                <div class="input-group-append">
                    <span class="input-group-text">Upload</span>
                </div>
                </div>
            </div>
    </div>
      <!-- /.card-body -->

    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>
</div>



  @endsection