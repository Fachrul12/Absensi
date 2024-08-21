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

    <div class="row"> 
        <div class="col-md-2">
            <div class="ml-3 mt-3 mb-3">
                <a href="{{ route('events.create') }}" class="btn btn-success btn-sm w-100">
                    Tambah <i class="fas fa-plus"></i>
                </a>
            </div>
        </div>    
    </div>

    <div class="card ml-3 mr-3">
        <div class="card-header text-white"" style="background-color: #4a525a ;">
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
                                        <i class="fas fa-eye"></i>
                                        Lihat
                                    </a>
                                    <a class="btn btn-info btn-sm" href="{{ route('events.edit', $event->id) }}">
                                        <i class="fas fa-pencil-alt"></i>
                                        Edit
                                    </a>
                                    <form action="{{ route('events.destroy', $event->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm ml-1">
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
          const deleteButtons = document.querySelectorAll('form button[type="submit"]');
        
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
