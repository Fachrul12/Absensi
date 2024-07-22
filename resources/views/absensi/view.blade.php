@extends('layouts.main')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-10">
          <h1 class="m-0">Absensi Event | {{ $event->nama_event }}</h1>
        </div><!-- /.col -->
        <div class="col-sm-2">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Event</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
    <hr class="m-0">
  </div>

  {{-- Button diatas table --}}    
    <div class="row">
        <div class="col-md-3">
          <div class="mb-2 ml-3 mt-3">
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Cari Event...">
              <div class="input-group-append">
                <button class="btn btn-primary btn-sm" type="button">
                  <i class="fas fa-search"></i>
                </button>
              </div>
            </div>
          </div>
        </div>              
    </div>

<div class="card ml-3 mr-3">
    <div class="card-header">
        <h3 class="card-title">List Peserta</h3>
        <a class="btn btn-success btn-sm float-right" href="{{ route('absensi.create', $event->id) }}">
            <i class="fas fa-check-square"></i>
            Absensi
        </a>
      </div>
    <!-- /.card-header -->

    <div class="card-body p-0">
          
      <table class="table table-condensed table-striped">
        <thead>
          <tr>
            <th style="width: 10px">No</th>
            <th>Foto</th>
            <th>Nama</th>
            <th>Partai</th>
            <th>Pendukung Calon</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          @foreach($pesertas as $peserta)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>
              <img src="{{ asset('storage/foto_peserta/'. $peserta->foto_peserta) }}" alt="Avatar" width="30" height="30" class="img-fluid rounded">
            </td>
            <td>{{ $peserta->nama_peserta }}</td>
            <td>{{ $peserta->partai->nama_partai }}</td>
            <td>{{ $peserta->pendukungCalon->nama_calon }}</td>
            <td>
              @if($peserta->status_hadir === 'Hadir')               
                <span class="badge badge-success">{{ $peserta->status_hadir }}</span>
              @else
                <span class="badge badge-danger">{{ $peserta->status_hadir }}</span>
              @endif
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <!-- /.card-body -->
  </div>

@endsection
