@extends('layouts.main')

@section('content')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Edit Peserta</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active"><a href="#">Home</a></li>
            <li class="breadcrumb-item active"><a href="/event">Event</a></li>
          </ol>
        </div>
      </div>
    </div>
    <hr class="m-0">
</div>

<div class="card card-primary ml-3 mr-3">
    <div class="card-header">
        <h3 class="card-title">Form Edit Peserta</h3>
    </div>
    <form action="{{ route('pesertas.update', $peserta->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="form-group">
                <label for="nama_peserta">Nama Peserta</label>
                <input type="text" class="form-control" id="nama_peserta" name="nama_peserta" value="{{ $peserta->nama_peserta }}" placeholder="Masukkan Nama">
            </div>
            <div class="form-group">
                <label for="kategori_peserta">Kategori Peserta</label>
                <select class="form-control" id="kategori_peserta" name="kategori_peserta">
                    <option value="">Pilih Kategori</option>
                    @foreach($kategoriPesertas as $kategori)
                        <option value="{{ $kategori->id }}" {{ $peserta->kategori_peserta_id == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori_peserta }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="isi_kategori_peserta_id">Isi Kategori Peserta</label>
                <select class="form-control" id="isi_kategori_peserta_id" name="isi_kategori_peserta_id">
                    <option value="">Pilih Isi Kategori</option>
                    <!-- Options will be populated by JavaScript -->
                </select>
            </div>
            <div class="form-group">
                <label for="foto_peserta">Foto Peserta</label>
                <div class="input-group">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="foto_peserta" name="foto_peserta">
                        <label class="custom-file-label" for="foto_peserta" id="file-label">
                            {{ $peserta->foto_peserta ? 'Change file' : 'Choose file' }}
                        </label>
                    </div>
                    <div class="input-group-append">
                        <span class="input-group-text">Upload</span>
                    </div>
                </div>
                @if($peserta->foto_peserta)
                    <img src="{{ asset('storage/foto_peserta/' . $peserta->foto_peserta) }}" alt="foto-peserta" width="100" height="100" class="img-fluid rounded mt-2">
                @endif
            </div>
            <input type="hidden" name="eventId" value="{{ $eventId }}" readonly>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Update</button>
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
                    option.textContent = item.nama_isi_kategori_peserta;
                    isiKategoriSelect.appendChild(option);
                });

                // Pre-select the current isi_kategori_peserta if it's already set
                if ('{{ $peserta->isi_kategori_peserta_id }}') {
                    isiKategoriSelect.value = '{{ $peserta->isi_kategori_peserta }}';
                }
            })
            .catch(error => console.error('Error fetching data:', error));
        } else {
            // If no category is selected, clear the isi_kategori_peserta options
            isiKategoriSelect.innerHTML = '<option value="">Pilih Isi Kategori</option>';
        }
    });

    // Trigger change event on page load to populate isi_kategori_peserta
    document.addEventListener('DOMContentLoaded', function() {
        var kategoriId = document.getElementById('kategori_peserta').value;
        if (kategoriId) {
            var event = new Event('change');
            document.getElementById('kategori_peserta').dispatchEvent(event);
        }
    });
</script>
@endsection
