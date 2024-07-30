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
                      @if($kategoris->isEmpty())
                        <p>Tidak ada kategori tersedia. <a href="{{ route('kategoris.create') }}" class="btn btn-primary btn-sm">Tambah Kategori</a></p>
                      @else
                        <select class="form-control" name="kategori_id">
                          <option value=""> - </option>
                            @foreach ($kategoris as $kategori)
                              <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                            @endforeach
                        </select>
                      @endif
                  </div>
              </div>
          </div>
      </div>                                

        <div class="form-group">
          <label for="tanggal_acara">Tanggal Acara</label>
          <input type="date" class="form-control" id="tanggal_acara" name="tanggal_acara" required>
        </div>
        <button type="submit" class="btn btn-success">Tambah Event</button>
      </form>
    </div>
    <!-- /.card-body -->
  </div>


  <script>
    let inputCount = 1;
  
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