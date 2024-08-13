@extends('layouts.main')

@section('content')
<div class="container">
    <h1>Edit Background</h1>
    <form action="{{ route('background.update', $background->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Nama Background</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $background->name }}" required>
        </div>
        <div class="form-group">
            <label for="image">Gambar Background</label>
            <input type="file" name="image" id="image" class="form-control-file" accept="image/*">
            @if($background->image)
                <div class="mt-2">
                    <img src="{{ asset('storage/backgrounds/' . $background->image) }}" alt="Current Background Image" class="img-thumbnail" style="max-width: 200px;">
                </div>
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('background.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
