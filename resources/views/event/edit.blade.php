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
          <input type="text" class="form-control" id="nama_event" name="nama_event" value="{{ $event->nama_event }}" required>
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
                            <option value="{{ $kategori->id }}" {{ $event->kategori_id == $kategori->id? 'selected' : '' }}>{{ $kategori->nama_kategori }}</option>
                        @endforeach
                    </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
          <label for="pendukung_calon">Pendukung Calon</label>
          <div id="pendukung-calon-inputs">
            @foreach ($pendukung_calon as $pendukung)
            <div class="input-group mb-2">
              <input type="text" class="form-control" name="pendukung_calon[]" value="{{ $pendukung->nama_calon }}" placeholder="Nama Pendukung Calon {{ $loop->iteration }}">
              <button class="btn btn-danger remove-input" type="button">-</button>
            </div>
            @endforeach
          </div>
          <button class="btn btn-primary add-input" type="button">Tambah Pendukung Calon</button>
        </div>

        <div class="form-group">
          <label for="tanggal_acara">Tanggal Acara</label>
          <input type="date" class="form-control" id="tanggal_acara" name="tanggal_acara" value="{{ $event->tanggal_acara }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Event</button>
      </form>
    </div>
    <!-- /.card-body -->
  </div>

  <script>
    let inputCount = {{ count($pendukung_calon) }};
  
    document.addEventListener("DOMContentLoaded", function() {
      const addInputButton = document.querySelector(".add-input");
      const removeInputButtons = document.querySelectorAll(".remove-input");
  
      addInputButton.addEventListener("click", function() {
        inputCount++;
        const newInput = document.createElement("div");
        newInput.innerHTML = `
          <div class="input-group mb-2">
            <input type="text" class="form-control" name="pendukung_calon[]" placeholder="Nama Pendukung Calon ${inputCount}">
            <button class="btn btn-danger remove-input" type="button">-</button>
          </div>
        `;
        document.getElementById("pendukung-calon-inputs").appendChild(newInput);
      });
  
      removeInputButtons.forEach(function(button) {
        button.addEventListener("click", function() {
          button.parentNode.remove();
          inputCount--;
        });
      });
    });
  </script>
@endsection