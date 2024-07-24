@extends('layouts.main')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Kelola Kategori kategori</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Kategori</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
    <hr class="m-0">
  </div>

  {{-- Button diatas table --}}
    <div class="col-md-2">
      <div class="mb-3 ml-2 mt-3">
        <a href="{{ route('kategoris.create') }}" class="btn btn-success btn-sm w-100">
          Tambah <i class="fas fa-plus"></i>
      </a>      
      </div>
    </div>
      

<div class="card ml-3">
    <div class="card-header">
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
    <!-- /.card-header -->

    <div class="card-body p-0">
      <table class="table table-condensed table-striped">
        <thead>
          <tr>
            <th style="width: 10px">No</th>            
            <th>kategori Event</th>
            <th style="width: 19%"></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($kategoris as $kategori)
              <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $kategori->nama_kategori }}</td>
                  <td class="project-actions text-right">
                    <div class="btn-group">
                          <a class="btn btn-primary btn-sm d-inline mr-1" href="{{ route('kategoris.edit', $kategori->id) }}">
                              <i class="fas fa-pencil-alt"></i>
                              Edit
                          </a>
                          <form action="{{ route('kategoris.destroy', $kategori->id) }}" method="POST">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="btn btn-danger btn-sm d-inline">
                                  <i class="fas fa-trash"></i>
                                  Delete
                              </button>
                          </form>  
                      </div>
                  </td>                                                             
              </tr>
          @endforeach
      </tbody>
      </table>
    </div>
    <!-- /.card-body -->
  </div>
@endsection