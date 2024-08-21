@extends('layouts.main')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit Peserta</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Edit Peserta</li> 
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
    <hr class="m-0">
</div>

<div class="card ml-3 mr-3">
    <div class="card-header text-white"" style="background-color: #4a525a ;">
        <h3 class="card-title">Form Edit Peserta</h3>
    </div>
    <!-- /.card-header -->

    <div class="card-body">
        <form action="{{ route('pesertas.update', $peserta->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="nama_peserta">Nama Peserta</label>
                <input type="text" class="form-control" id="nama_peserta" name="nama_peserta" value="{{ old('nama_peserta', $peserta->nama_peserta) }}" required>
            </div>

            <div class="form-group">
                <label for="kategori_id">Kategori Peserta</label>
                <select class="form-control" id="kategori_id" name="kategori_id" required>
                    <option value="">- Pilih Kategori -</option>
                    @foreach($kategoriPesertas as $kategori)
                        <option value="{{ $kategori->id }}" {{ $peserta->isiKategoriPeserta->kategori_peserta_id == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="isi_kategori_peserta_id">Isi Kategori Peserta</label>
                <select class="form-control" id="isi_kategori_peserta_id" name="isi_kategori_peserta_id" required>
                    @foreach($isiKategoriPesertas as $isiKategori)
                        <option value="{{ $isiKategori->id }}" {{ $peserta->isi_kategori_peserta_id == $isiKategori->id ? 'selected' : '' }}>
                            {{ $isiKategori->nama_isi_kategori_peserta }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="foto_peserta">Foto Peserta</label>
                <input type="file" class="form-control" id="foto_peserta" name="foto_peserta">
                @if($peserta->foto_peserta)
                    <img src="{{ asset('storage/foto_peserta/' . $peserta->foto_peserta) }}" alt="Foto Peserta" class="mt-2" style="max-width: 150px;">
                @endif
            </div>

            <button type="submit" class="btn btn-success">Update Peserta</button>
        </form>
    </div>
    <!-- /.card-body -->
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const kategoriSelect = document.getElementById('kategori_id');
        const isiKategoriSelect = document.getElementById('isi_kategori_peserta_id');
        
        kategoriSelect.addEventListener('change', function() {
            const kategoriId = this.value;
            if (kategoriId) {
                fetch(`/isi-kategori/${kategoriId}`)
                    .then(response => response.json())
                    .then(data => {
                        isiKategoriSelect.innerHTML = '<option value="">- Pilih Isi Kategori -</option>';
                        data.forEach(isiKategori => {
                            isiKategoriSelect.innerHTML += `<option value="${isiKategori.id}">${isiKategori.nama_isi_kategori_peserta}</option>`;
                        });
                    });
            } else {
                isiKategoriSelect.innerHTML = '<option value="">- Pilih Isi Kategori -</option>';
            }
        });

        // Set initial value of isi_kategori_peserta_id
        const initialIsiKategoriId = '{{ $peserta->isi_kategori_peserta_id }}';
        if (initialIsiKategoriId) {
            isiKategoriSelect.value = initialIsiKategoriId;
        }
    });
</script>
@endsection
