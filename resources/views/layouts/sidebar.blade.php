<!-- Brand Logo -->
<a href="/" class="brand-link">
    <img src="/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">SCANNER</span>
  </a>
  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">{{ auth()->user()->name }}</a>  {{--Nanti Administrator diganti ke usernmae yang namonyo diambil dari database --}}
      </div>
    </div>     
  <!-- Sidebar Menu -->
  <nav class="mt-2">
  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">     
      
    
      <li class="nav-item menu-open">
        <a href="/dashboard" class="nav-link">
          <i class="nav-icon fas fa-home"></i>
          <p>
            Dashboard
          </p>
        </a>
      </li>
      <li class="nav-item menu-open">
        <a href="/absensi" class="nav-link">
          <i class="nav-icon fas fa-calendar"></i>
          <p>
            Absensi Acara
          </p>
        </a>
      </li>
    @can('admin')
    <li class="nav-header">ADMINISTRATOR</li>
    <li class="nav-item menu-open">
      <a href="/events" class="nav-link">
        <i class="nav-icon fas fa-calendar"></i>
        <p>
          Acara
        </p>
      </a>
    </li>
    <li class="nav-item menu-open">
      <a href="/partais" class="nav-link">
        <i class="nav-icon fas fa-users"></i>
          <p>
            Partai
          </p>
      </a>
    </li>
    <li class="nav-item menu-open">
      <a href="/kategoris" class="nav-link">
        <i class="nav-icon fas fa-tags"></i>
          <p>
            Kategori
          </p>
      </a>
    </li>
    <li class="nav-item menu-open">
      <a href="/users" class="nav-link">
        <i class="nav-icon fas fa-user"></i>
          <p>
            Pengguna
          </p>
      </a>
    </li>
    
    @endcan
    
      
  </ul>
   
  </nav>
  <!-- /.sidebar-menu -->    
  <!-- /.content-header -->
  </div>
  <!-- /.sidebar -->
