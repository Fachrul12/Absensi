@extends('layouts.main')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Partai</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Partai</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
    <hr class="m-0">
  </div>

  {{-- Button diatas table --}}
    <div class="col-md-2">
      <div class="mb-1 ml-2 mt-3">
        <a href="#" class="btn btn-success btn-sm w-100">
          Tambah <i class="fas fa-plus"></i>
        </a>
      </div>
    </div>
  
    
    <div class="row">
        <div class="col-md-3 mr-3">
          <div class="mb-2 ml-3 mt-3">
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
      
        <div class="col-md-2">
          <div class="mb-2 ml-1 mt-3">
            <a href="#" class="btn btn-success btn-sm w-10">
              Export Excel
            </a>
          </div>
        </div>
      </div>


<div class="card ml-3">
    <div class="card-header">
      <h3 class="card-title">List Partai</h3>      
    </div>
    <!-- /.card-header -->

    <div class="card-body p-0">
      <table class="table table-condensed table-striped">
        <thead>
          <tr>
            <th style="width: 10px">No</th>
            <th>Foto</th>
            <th>Nama Partai</th>
            <th style="width: 19%"></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>1</td>
            <td>
              <img src="{{ asset('dist/img/avatar.png') }}" alt="Avatar" width="30" height="30" class="img-fluid rounded">
            </td>
            <td>Demokrat</td>
            <td class="project-actions text-right">
              <a class="btn btn-info btn-sm" href="#">
                <i class="fas fa-pencil-alt"></i>
                Edit
              </a>
              <a class="btn btn-danger btn-sm" href="#">
                <i class="fas fa-trash"></i>
                Delete
              </a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <!-- /.card-body -->
  </div>
@endsection