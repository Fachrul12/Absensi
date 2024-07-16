@extends('layouts.main')
@section('content')

<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Tambah Pengguna Baru</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Pengguna</a></li>
            <li class="breadcrumb-item active">Tambah Pengguna</li>
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
              <h3 class="card-title">Tambah Pengguna</h3>
            </div>
            <div class="card-body">
              <form method="POST" action="{{ route('users.store') }}">
                @csrf
                <div class="form-group">
                  <label for="name">Nama Lengkap</label>
                  <div class="input-group mb-3">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Full Name" name="name" id="name" autofocus 
                    required value="{{ old('name') }}">
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="fas fa-user"></span>
                      </div>
                    </div>
                    @error('name')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror            
                  </div>
                </div>
              
                {{-- Username --}}
                <div class="form-group">
                  <label for="username">Username</label>
                  <div class="input-group mb-3">
                    <input type="text" class="form-control @error('username') is-invalid @enderror" placeholder="Username" name="username" id="username" autofocus 
                    required value="{{ old('username') }}">
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="fas fa-user"></span>
                      </div>
                    </div>
                    @error('username')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror            
                  </div>
                </div>
  
                {{-- Email --}}
                <div class="form-group">
                  <label for="email">Email</label>
                  <div class="input-group mb-3">
                    <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" name="email" id="email" autofocus 
                    required value="{{ old('email') }}">
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                      </div>
                    </div>
                    @error('email')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror            
                  </div>
                </div>
  
                {{-- Password --}}
                <div class="form-group">
                  <label for="password">Password</label>
                  <div class="input-group mb-3">
                    <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" name="password" id="password">
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                      </div>
                    </div>
                    @error('password')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror
                  </div>                
                </div>

                <div class="form-group">
                  <label for="password_confirmation">Confirm Password</label>
                  <div class="input-group mb-3">
                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Confirm Password" name="password_confirmation" id="password_confirmation">
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                      </div>
                    </div>
                    @error('password_confirmation')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror
                  </div>
                </div>

                <div class="form-group">
                  <label for="is_admin">Role</label>
                  <div class="input-group">
                    <select class="form-control" id="is_admin" name="is_admin">
                      <option value="0">User</option>
                      <option value="1">Admin</option>
                    </select>
                    <div class="input-group-append">
                      <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                    </div>
                  </div>
                </div>
  
                <div class="row">
                  <div class="col-12">
                    <button type="submit" class="btn btn-primary btn-block">Tambah</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
