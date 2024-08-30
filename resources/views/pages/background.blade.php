@extends('layouts.main')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Kelola Kategori</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Kategori</li>
                </ol>
            </div>
        </div>
    </div>
    <hr class="m-0">
</div>

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif

<!-- Button di atas table -->
<div class="col-md-2">
    <div class="mb-3 ml-2 mt-3">
        <a href="{{ route('background.create') }}" class="btn btn-success btn-sm w-100">
            Tambah Background <i class="fas fa-plus"></i>
        </a>
    </div>
</div>

<!-- Card with table -->
<div class="card ml-3">
    <div class="card-header text-white"" style="background-color: #4a525a ;">
        <h3 class="card-title">List Kategori</h3>
        <div class="card-tools">
            <div class="input-group input-group-sm" style="width: 150px;">
                <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-default">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Table with actions -->
    <div class="card-body p-0">
        <table class="table table-condensed table-striped">
            <thead>
                <tr>
                    <th style="width: 10px">No</th>
                    <th>Nama Background</th>
                    <th style="width: 19%"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($backgrounds as $background)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $background->name }}</td>
                    <td class="project-actions text-right">
                        <div class="btn-group">
                            <div class="dropdown d-inline mr-2">
                                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton{{ $background->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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

                            <a href="{{ route('background.edit', $background->id) }}" class="btn btn-info btn-sm d-inline ml-1 mr-1">
                                <i class="fas fa-pencil-alt"></i> Edit
                            </a>
                            <form action="{{ route('background.destroy', $background->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm btn-delete">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                            <a href="{{ route('background.preview', $background->id) }}" class="btn btn-primary btn-sm d-inline ml-1">
                                <i class="fas fa-eye"></i> Preview
                            </a>
                        </div>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
      const deleteButtons = document.querySelectorAll('button.btn-delete');
    
      deleteButtons.forEach(function(button) {
          button.addEventListener('click', function(event) {
              event.preventDefault(); // Prevent the form from submitting immediately
    
              const confirmation = confirm('Apakah Anda yakin ingin menghapus Acara ini?');
    
              if (confirmation) {
                  this.closest('form').submit(); // Submit the form if confirmed
              }
          });
      });
    });
    </script>
@endsection
