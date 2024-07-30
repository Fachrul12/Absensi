@extends('layouts.main')

@section('content')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Tambah Peserta</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="/event">Event</a></li>
          </ol>
        </div>
      </div>
    </div>
    <hr class="m-0">
</div>

<div class="card card-primary ml-3 mr-3">
    <div class="card-header">
        <h3 class="card-title">Form Peserta</h3>
    </div>
    <form action="{{ route('pesertas.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="nama_peserta">Nama Peserta</label>
                <input type="text" class="form-control" id="nama_peserta" name="nama_peserta" placeholder="Masukkan Nama" required>
            </div>
            <div class="form-group">
                <label for="kategori_peserta">Kategori Peserta</label>
                <select class="form-control" id="kategori_peserta" name="kategori_peserta" required>
                    <option value="">Pilih Kategori</option>
                    @foreach($kategoriPesertas as $kategori)
                        <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori_peserta }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="isi_kategori_peserta">Isi Kategori Peserta</label>
                <select class="form-control" id="isi_kategori_peserta_id" name="isi_kategori_peserta_id" required>
                    <option value="">Pilih Isi Kategori</option>
                </select>
            </div>
            <div class="form-group">
                <label for="foto_peserta">Foto Peserta</label>
                <div class="input-group">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="foto_peserta" name="foto_peserta" required>
                        <label class="custom-file-label" for="foto_peserta">Choose file</label>
                    </div>
                    <div class="input-group-append">
                        <span class="input-group-text">Upload</span>
                    </div>
                </div>
            </div>
            <input type="hidden" name="eventId" value="{{ $eventId }}" readonly>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>

<script>
document.getElementById('kategori_peserta').addEventListener('change', function() {
    var kategoriId = this.value;
    var isiKategoriSelect = document.getElementById('isi_kategori_peserta_id');
    
    // Clear existing options
    isiKategoriSelect.innerHTML = '<option value="">Pilih Isi Kategori</option>';
    
    // Fetch the corresponding Isi Kategori Peserta based on kategoriId
    if (kategoriId) {
        fetch(`/get-isi-kategori/${kategoriId}`)
        .then(response => response.json())
        .then(data => {
            data.forEach(item => {
                var option = document.createElement('option');
                option.value = item.id;
                option.textContent = item.nama_isi_kategori_peserta; // Use nama_isi_kategori_peserta_id for the option text
                isiKategoriSelect.appendChild(option);
            });
        })
        .catch(error => console.error('Error fetching data:', error));
    }
});
</script>
@endsection
