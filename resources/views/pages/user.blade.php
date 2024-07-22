@extends('layouts.main')
@section('content')

<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Pengguna</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Pengguna</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
  
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Daftar Pengguna</h3>
              <div class="card-tools">
                <a href="{{ route('users.create') }}" class="btn btn-success btn-sm">Tambah Pengguna</a>
              </div>
            </div>
            <div class="card-body">
              <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($users as $user)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->is_admin ? 'Admin' : 'Petugas' }}</td>
                    <td>
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-sm">Edit</a>                   
                          <div class="modal fade" id="deleteModal-{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                  <div class="modal-body">
                                    Apakah anda yakin ingin menghapus pengguna ini?
                                  </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                        <form id="delete-form-{{ $user->id }}" action="{{ route('users.destroy', $user->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                      <button type="submit" class="btn btn-danger">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                              </div>
                            </div>
                          <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal-{{ $user->id }}">Hapus</button>
                        
                        
                        {{-- <form action="{{ route('users.destroy', $user->id) }}" method="post" style="display: inline;">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form> --}}
                      
                      
                      </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


@endsection