<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Registration</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>
<body class="hold-transition register-page">
    <div class="register-box">
      <div class="register-logo">
        <a href=""><b>Absensi</b></a>
      </div>     
    
      <!-- /.register-logo -->
      <div class="card">
        <div class="card-body register-card-body">
          <p class="register-box-msg">Register a new membership</p>    
                    
          <form action="/register" method="post">    
            @csrf   
            
            {{-- Name --}}
            <div class="input-group mb-3">
                <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Full Name" name="name" id="name" autofocus 
                required value="{{ old('name', '') }}">
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
                required value="{{ old('username', '') }}">
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
                required value="{{ old('email', '') }}">
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
                <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" name="password" id="password" required>
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
            
            <div class="row">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary btn-block">Register</button>
                </div>
                <!-- /.col -->
            </div>            
        </form>           
        </div>
        <!-- /.register-card-body -->
      </div>
        <p class="mb-1 mt-3 text-center">
        <a href="/login">Already have an account?</a>
        </p>  
    </div>
    <!-- /.register-box -->
    
    <!-- jQuery -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
      <!-- Bootstrap 4 -->
      <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
      <!-- AdminLTE App -->
      <script src="../../dist/js/adminlte.min.js"></script>
      </body>
  </html>