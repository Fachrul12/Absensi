@extends('layouts.main')
@inject('carbon', '\Carbon\Carbon')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">List Acara</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">List Acara</li>
                </ol>
            </div>
        </div>
    </div>
    <hr class="m-0">
</div>

<div class="container">
    <div class="row mb-3">
        <div class="col-sm-12">
            <!-- Tombol untuk menambahkan background -->
            <a href="{{ route('background.create') }}" class="btn btn-primary">
                Tambah Background
            </a>
        </div>
    </div>

    <!-- Tabel Daftar Background -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Nama Background</th>
                    <th>Assign ke Event</th>
                    <th>Edit</th>
                    <th>Delete</th>
                    <th>Preview</th> <!-- Tambahkan kolom baru untuk tombol preview -->
                </tr>
            </thead>
            <tbody>
                @foreach($backgrounds as $background)
                <tr>
                    <td>{{ $background->name }}</td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton{{ $background->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Pilih Event
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $background->id }}">
                                <form action="{{ route('background.assignMultiple', $background->id) }}" method="POST">
                                    @csrf
                                    @foreach($events as $event)
                                        <div class="form-check ml-2">
                                            <input class="form-check-input" type="checkbox" name="events[]" value="{{ $event->id }}" id="event{{ $event->id }}" 
                                                @if($background->events->contains($event->id)) checked @endif>
                                            <label class="form-check-label ml-1" for="event{{ $event->id }}">
                                                {{ $event->nama_event }}
                                            </label>
                                        </div>
                                    @endforeach
                                    <button type="submit" class="btn btn-primary btn-sm mt-2 ml-2">Assign</button>
                                </form>
                            </div>
                        </div>
                    </td>
                    <td><a href="{{ route('background.edit', $background->id) }}" class="btn btn-info btn-sm">Edit</a></td>
                    <td>
                        <form action="{{ route('background.destroy', $background->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this background?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                    <td>
                        <!-- Tombol untuk menuju halaman preview -->
                        <a href="{{ route('background.preview', $background->id) }}" class="btn btn-primary btn-sm">Preview</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection