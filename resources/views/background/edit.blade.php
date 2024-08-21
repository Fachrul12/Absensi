@extends('layouts.main')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit Background</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('background.index') }}">Kembali</a></li>
                    <li class="breadcrumb-item active">Edit Background</li>
                </ol>
            </div>
        </div>
    </div>
    <hr class="m-0">
</div>

<div class="card ml-3 mr-3">
    <div class="card-header text-white"" style="background-color: #4a525a ;">
        <h3 class="card-title">Form Edit Background</h3>
    </div>
    <!-- /.card-header -->

    <div class="card-body">
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
    <!-- /.card-body -->
</div>

@endsection
