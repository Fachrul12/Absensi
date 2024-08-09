@extends('layouts.main')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Edit Event</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Edit Event</li> 
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
    <hr class="m-0">
  </div>

<div class="card ml-3 mr-3">
    <div class="card-header">
        <h3 class="card-title">Form Edit Event</h3>
    </div>
    <!-- /.card-header -->

    <div class="card-body">
        <form action="{{ route('events.update', $event->id) }}" method="post">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="nama_event">Nama Event</label>
                <input type="text" class="form-control" id="nama_event" name="nama_event" value="{{ old('nama_event', $event->nama_event) }}" required>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-sm-12">
                        <!-- select -->
                        <div class="form-group">
                            <label>Kategori Event</label>
                            @if($kategoris->isEmpty())
                                <p>Tidak ada kategori tersedia. <a href="{{ route('kategoris.create') }}" class="btn btn-primary btn-sm">Tambah Kategori</a></p>
                            @else
                                <select class="form-control" name="kategori_id">
                                    <option value=""> - </option>
                                    @foreach ($kategoris as $kategori)
                                        <option value="{{ $kategori->id }}" {{ $event->kategori_id == $kategori->id ? 'selected' : '' }}>
                                            {{ $kategori->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="tanggal_acara">Tanggal Acara</label>
                <input type="date" class="form-control" id="tanggal_acara" name="tanggal_acara" value="{{ old('tanggal_acara', $event->tanggal_acara) }}" required>
            </div>

            <button type="submit" class="btn btn-success">Update Event</button>
        </form>
    </div>
    <!-- /.card-body -->
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Optionally handle dynamic input fields if needed
        // For now, no dynamic fields are present in the edit form
    });
</script>
@endsection
