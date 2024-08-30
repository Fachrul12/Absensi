@extends('layouts.main')
@inject('carbon', '\Carbon\Carbon')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Absensi Acara</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Absensi Acara</li>
                    </ol>
                </div>
            </div>
        </div>
        <hr class="m-0">
    </div>

    <!-- Import JSON Form -->
    <form action="{{ route('events.import') }}" method="POST" enctype="multipart/form-data" class="d-inline-block mb-3 ml-3">
        @csrf
        <div class="input-group">
            <input type="file" name="import_file" class="form-control-file">
            <div class="input-group-append">
                <button type="submit" class="btn btn-success btn-sm">
                    <i class="fas fa-upload"></i> Import JSON
                </button>
            </div>
        </div>
    </form>

    <div class="card ml-3 mr-3">
        <div class="card-header text-white" style="background-color: #4a525a;">
            <h3 class="card-title">List Acara</h3>
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

        <div class="card-body p-0">
            <table class="table table-condensed table-striped">
                <thead>
                    <tr>
                        <th style="width: 10px">No</th>
                        <th>Nama Event</th>
                        <th>Peserta</th>
                        <th>Tanggal Acara</th>
                        <th style="cursor: pointer;">
                            <a href="{{ route('absensi.index', ['sort' => 'status', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}">
                                Status Acara 
                                @if(request('sort') == 'status' && request('direction') == 'asc')
                                    <i class="fas fa-sort-up"></i>
                                @elseif(request('sort') == 'status' && request('direction') == 'desc')
                                    <i class="fas fa-sort-down"></i>
                                @else
                                    <i class="fas fa-sort"></i>
                                @endif
                            </a>
                        </th>
                        <th style="width: 30%"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($events as $event)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $event->nama_event }}</td>
                            <td>{{ optional($event->peserta)->count() ?? 0 }}</td>
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
                                <a class="btn btn-primary btn-sm d-inline mr-1" href="{{ route('absensi.show', $event->id) }}">
                                    <i class="fas fa-folder"></i> Lihat
                                </a>                                    
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
