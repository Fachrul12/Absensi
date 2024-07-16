@extends('layouts.main')
@section('content')

<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Edit Pengguna</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Pengguna</a></li>
            <li class="breadcrumb-item active">Edit Pengguna</li>
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
              <h3 class="card-title">Edit Pengguna</h3>
            </div>
            <div class="card-body">
              <form method="POST" action="{{ route('users.update', $user->id) }}">
                @csrf
                @method('PUT')
                <div class="input-group mb-3">
                  <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Full Name" name="name" id="name" autofocus 
                  required value="{{ old('name', $user->name) }}">
                  <div class="input-group-append">
                      <div class="input-group-text">
                          <span class="fas fa-user"></span>
                          @error('name')
                              <span class="fas fa-exclamation-triangle text-danger"></span>
                          @enderror
                      </div>
                  </div>
                  @error('name')
                      <div class="invalid-feedback">
                          {{ $message }}
                      </div>
                  @enderror            
              </div>
              
              {{-- Username --}}
              <div class="input-group mb-3">
                  <input type="text" class="form-control @error('username') is-invalid @enderror" placeholder="Username" name="username" id="username" autofocus 
                  required value="{{ old('username', $user->username) }}">
                  <div class="input-group-append">
                      <div class="input-group-text">
                          <span class="fas fa-user"></span>
                          @error('username')
                              <span class="fas fa-exclamation-triangle text-danger"></span>
                          @enderror
                      </div>
                  </div>
                  @error('username')
                      <div class="invalid-feedback">
                          {{ $message }}
                      </div>
                  @enderror            
              </div>
  
              {{-- Email --}}
              <div class="input-group mb-3">
                  <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" name="email" id="email" autofocus 
                  required value="{{ old('email', $user->email) }}">
                  <div class="input-group-append">
                      <div class="input-group-text">
                          <span class="fas fa-envelope"></span>
                          @error('email')
                              <span class="fas fa-exclamation-triangle text-danger"></span>
                          @enderror
                      </div>
                  </div>
                  @error('email')
                      <div class="invalid-feedback">
                          {{ $message }}
                      </div>
                  @enderror            
              </div>
  
              {{-- Password --}}
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
  
              {{-- Confirm Password --}}
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
  
              <div class="row">
                  <div class="col-12">
                      <button type="submit" class="btn btn-primary btn-block">Update</button>
                  </div>
                  <!-- /.col -->
              </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


@endsection