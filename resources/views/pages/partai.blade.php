@extends('layouts.main')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Partai</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Partai</li>
                </ol>
            </div>
        </div>
    </div>
    <hr class="m-0">
</div>

<!-- Button and Search Bar -->
<div class="row mb-2 ml-2">
    <div class="col-md-3">
        <a href="{{ route('partais.create') }}" class="btn btn-success btn-sm w-35 ">
            <i class="fas fa-plus"></i> Tambah 
        </a>
        <a href="#" class="btn btn-success btn-sm w-35 ">
            Export Excel
        </a>
    </div>
    <div class="ml-auto mr-3">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Cari Partai...">
            <div class="input-group-append">
                <button class="btn btn-primary btn-sm" type="button">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- List Partai -->
<div class="card ml-3">
    <div class="card-header">
        <h3 class="card-title">List Partai</h3>
    </div>
    <div class="card-body p-0">
        <table class="table table-condensed table-striped">
            <thead>
                <tr>
                    <th style="width: 10px">No</th>
                    <th>Bendera</th>
                    <th>Nama Partai</th>
                    <th style="width: 19%"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($partais as $partai)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        @if($partai->bendera_partai)
                            <img src="{{ asset('storage/partai/' . $partai->bendera_partai) }}" alt="Bendera Partai" width="30" height="30" class="img-fluid rounded">
                        @else
                            <img src="{{ asset('dist/img/avatar.png') }}" alt="Avatar" width="30" height="30" class="img-fluid rounded">
                        @endif
                    </td>
                    <td>{{ $partai->nama_partai }}</td>
                    <td class="project-actions text-right">
                        <a class="btn btn-info btn-sm" href="{{ route('partais.edit', $partai->id) }}">
                            <i class="fas fa-pencil-alt"></i>
                            Edit
                        </a>
                        <a class="btn btn-danger btn-sm" href="#" onclick="event.preventDefault(); document.getElementById('delete-partai-{{ $partai->id }}').submit();">
                            <i class="fas fa-trash"></i>
                            Delete
                        </a>
                        <form id="delete-partai-{{ $partai->id }}" action="{{ route('partais.destroy', $partai->id) }}" method="post" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection