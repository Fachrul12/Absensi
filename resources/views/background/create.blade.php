@extends('layouts.main')

@section('content')
<div class="container">
    <h1>Tambah Background</h1>
    <form action="{{ route('background.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">Nama Background</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="image">Gambar Background</label>
            <input type="file" name="image" id="image" class="form-control-file" accept="image/*" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('background.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
