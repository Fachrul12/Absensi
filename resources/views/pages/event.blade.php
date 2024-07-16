@extends('layouts.main')
@inject('carbon', '\Carbon\Carbon')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Acara</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Acara</li>
                    </ol>
                </div>
            </div>
        </div>
        <hr class="m-0">
    </div>
    <div class="row">
        <div class="col-md-2">
            <div class="ml-3 mt-3">
                <a href="{{ route('events.create') }}" class="btn btn-success btn-sm w-100">
                    Tambah <i class="fas fa-plus"></i>
                </a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="mb-2 ml-3 mt-3">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Cari Event...">
                    <div class="input-group-append">
                        <button class="btn btn-primary btn-sm" type="button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card ml-3 mr-3">
        <div class="card-header">
            <h3 class="card-title">List Acara</h3>
        </div>
        <div class="card-body p-0">
            <table class="table table-condensed table-striped">
                <thead>
                    <tr>
                        <th style="width: 10px">No</th>
                        <th>Nama Event</th>
                        <th>Peserta</th>
                        <th>Tanggal Acara</th>
                        <th>Status Acara</th>
                        <th style="width: 30%"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($events as $event)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $event->nama_event }}</td>
                            <td>{{ optional($event->peserta)->count()?? 0 }}</td>
                            <td>{{ $event->tanggal_acara }}</td>
                            <td>
                                @php
                                    $tanggalAcara = \Carbon\Carbon::parse($event->tanggal_acara);
                                @endphp
                                @if($tanggalAcara < now()->startOfDay())
                                    <span class="badge badge-success">Selesai</span>
                                @elseif($tanggalAcara->isToday())
                                    <span class="badge badge-primary">Berlangsung</span>
                                @else
                                    <span class="badge badge-danger">Belum Selesai</span>
                                @endif
                            </td>
                            <td class="project-actions text-right">
                                <div class="btn-group">
                                    <a class="btn btn-primary btn-sm d-inline mr-1" href="{{ route('events.show', $event->id) }}">
                                        <i class="fas fa-folder"></i>

                                        Lihat
                                    </a>
                                    <a class="btn btn-primary btn-sm d-inline mr-1" href="{{ route('events.edit', $event->id) }}">
                                        <i class="fas fa-pencil-alt"></i>

                                        Ubah
                                    </a>
                                    <form action="{{ route('events.destroy', $event->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm d-inline">
                                            <i class="fas fa-trash"></i>

                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
