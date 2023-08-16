<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
  <meta name="author" content="Creative Tim">
  <title>Ventas</title>
  <link rel="icon" type="image/x-icon" href="{{ asset('img/icono.png') }}">
  
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <link href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css" rel="stylesheet">
  
  @yield('estilos')
  <!--styles-->
  @stack('styles')
  <!-- Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
  
  @vite('resources/js/app.js')

  <!-- Icons -->
  @vite('resources/vendor/nucleo/css/nucleo.css')
  @vite('resources/vendor/@fortawesome/fontawesome-free/css/all.min.css')
  
  <!-- Page plugins -->
  <!-- Argon CSS -->
  @vite('resources/css/argon.css')

  <link rel="stylesheet" href="{{ asset('select2/dist/css/select2.min.css') }}">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



</head>

<style>
  
.navbar-nav .nav-item .nav-link:hover {
    background-color: #f8f9fa; /* Cambia al color deseado */
    color: #007bff; /* Cambia al color deseado */
}

</style>

@auth  
<body>
@endauth  

@guest
  <body class="bg-default">
@endguest

  @auth  
  <!-- Sidenav -->
  <nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
      <!-- Brand -->
      <div class="sidenav-header  align-items-center">
        <a class="navbar-brand" href="/">
          <img src="{{ asset ('img/icono.png') }}" class="navbar-brand-img" alt="logo">
          <img src="{{ asset ('img/ventas.png') }}" class="navbar-brand-img" alt="logo" style="width: 60px;">
        </a>
      </div>

      <div class="navbar-inner">
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
          <!-- Nav items -->
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" href="{{route('posts.index',[auth()->user()])}}">
              <i class="ni ni-chart-bar-32 text-primary"></i>
                <span class="nav-link-text">Dashboard</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{route('productos.index')}}">
                <i class="ni ni-box-2 text-orange"></i>
                <span class="nav-link-text">Productos</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{route('categorias.index')}}">
                <i class="ni ni-bullet-list-67 text-primary"></i>
                <span class="nav-link-text">Categorias</span>
              </a>
            </li>
            
            <li class="nav-item">
              <a class="nav-link" href="{{route('subcategorias.index')}}">
                <i class="ni ni-ui-04 text-yellow"></i>
                <span class="nav-link-text">Subcategorías</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{route('marcas.index')}}">
                <i class="ni ni-tag text-default"></i>
                <span class="nav-link-text">Marcas</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{route('ventas.index')}}">
                <i class="ni ni-money-coins text-info"></i>
                <span class="nav-link-text">Ventas</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{route('devoluciones.index')}}">
                <i class="ni ni-curved-next text-pink"></i>
                <span class="nav-link-text">Devoluciones</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{route('clientes.index')}}">
                <i class="ni ni-single-02 text-dark"></i>
                <span class="nav-link-text">Clientes</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{route('proveedores.index')}}">
                <i class="ni ni-building text-primary"></i>
                <span class="nav-link-text">Proveedores</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{route('usuarios.index')}}">
                <i class="ni ni-single-02 text-orange"></i>
                <span class="nav-link-text">Usuarios</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{route('compras.index')}}">
                <i class="ni ni-cart text-primary"></i>
                <span class="nav-link-text">Compras</span>
              </a>
            </li>
          </ul>
        </div>
      </div>

    </div>
  </nav>
  @endauth

  <!-- Main content -->
  <div class="main-content" id="panel">
    @auth  
    <!-- Topnav -->
    <nav class="navbar navbar-top navbar-expand navbar-dark bg-primary border-bottom">
      <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <!-- Search form -->
          <form class="navbar-search navbar-search-light form-inline mr-sm-3" id="navbar-search-main">
            <div class="form-group mb-0">
              <div class="input-group input-group-alternative input-group-merge">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-search"></i></span>
                </div>
                <input class="form-control" placeholder="Search" type="text">
              </div>
            </div>
            <button type="button" class="close" data-action="search-close" data-target="#navbar-search-main" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </form>
          <!-- Navbar links -->
          <ul class="navbar-nav align-items-center  ml-md-auto ">
            <li class="nav-item d-xl-none">
              <!-- Sidenav toggler -->
              <div class="pr-3 sidenav-toggler sidenav-toggler-dark" data-action="sidenav-pin" data-target="#sidenav-main">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                </div>
              </div>
            </li>
            <li class="nav-item d-sm-none">
              <a class="nav-link" href="#" data-action="search-show" data-target="#navbar-search-main">
                <i class="ni ni-zoom-split-in"></i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{route('ventas.create')}}" >
                <i class="ni ni-shop"></i>
              </a>
            </li>
           
            <!-- <li class="nav-item dropdown">
              <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="ni ni-bell-55"></i>
              </a>
              <div class="dropdown-menu dropdown-menu-xl  dropdown-menu-right  py-0 overflow-hidden">
                
                <div class="px-3 py-3">
                  <h6 class="text-sm text-muted m-0">You have <strong class="text-primary">13</strong> notifications.</h6>
                </div>
                <div class="list-group list-group-flush">
                  <a href="#!" class="list-group-item list-group-item-action">
                    <div class="row align-items-center">
                      <div class="col-auto">
                        <img alt="Image placeholder" src="{{ asset ('img/theme/team-1.jpg') }}" class="avatar rounded-circle">
                      </div>
                      <div class="col ml--2">
                        <div class="d-flex justify-content-between align-items-center">
                          <div>
                            <h4 class="mb-0 text-sm">John Snow</h4>
                          </div>
                          <div class="text-right text-muted">
                            <small>2 hrs ago</small>
                          </div>
                        </div>
                        <p class="text-sm mb-0">Let's meet at Starbucks at 11:30. Wdyt?</p>
                      </div>
                    </div>
                  </a>
                  <a href="#!" class="list-group-item list-group-item-action">
                    <div class="row align-items-center">
                      <div class="col-auto">
                        <img alt="Image placeholder" src="{{ asset ('img/theme/team-2.jpg') }}" class="avatar rounded-circle">
                      </div>
                      <div class="col ml--2">
                        <div class="d-flex justify-content-between align-items-center">
                          <div>
                            <h4 class="mb-0 text-sm">John Snow</h4>
                          </div>
                          <div class="text-right text-muted">
                            <small>3 hrs ago</small>
                          </div>
                        </div>
                        <p class="text-sm mb-0">A new issue has been reported for Argon.</p>
                      </div>
                    </div>
                  </a>
                  <a href="#!" class="list-group-item list-group-item-action">
                    <div class="row align-items-center">
                      <div class="col-auto">
                        <img alt="Image placeholder" src="{{ asset ('img/theme/team-3.jpg') }}" class="avatar rounded-circle">
                      </div>
                      <div class="col ml--2">
                        <div class="d-flex justify-content-between align-items-center">
                          <div>
                            <h4 class="mb-0 text-sm">John Snow</h4>
                          </div>
                          <div class="text-right text-muted">
                            <small>5 hrs ago</small>
                          </div>
                        </div>
                        <p class="text-sm mb-0">Your posts have been liked a lot.</p>
                      </div>
                    </div>
                  </a>
                  <a href="#!" class="list-group-item list-group-item-action">
                    <div class="row align-items-center">
                      <div class="col-auto">
                        <img alt="Image placeholder" src="{{ asset ('img/theme/team-4.jpg') }}" class="avatar rounded-circle">
                      </div>
                      <div class="col ml--2">
                        <div class="d-flex justify-content-between align-items-center">
                          <div>
                            <h4 class="mb-0 text-sm">John Snow</h4>
                          </div>
                          <div class="text-right text-muted">
                            <small>2 hrs ago</small>
                          </div>
                        </div>
                        <p class="text-sm mb-0">Let's meet at Starbucks at 11:30. Wdyt?</p>
                      </div>
                    </div>
                  </a>
                  <a href="#!" class="list-group-item list-group-item-action">
                    <div class="row align-items-center">
                      <div class="col-auto">
                        <img alt="Image placeholder" src="{{ asset ('img/theme/team-5.jpg') }}" class="avatar rounded-circle">
                      </div>
                      <div class="col ml--2">
                        <div class="d-flex justify-content-between align-items-center">
                          <div>
                            <h4 class="mb-0 text-sm">John Snow</h4>
                          </div>
                          <div class="text-right text-muted">
                            <small>3 hrs ago</small>
                          </div>
                        </div>
                        <p class="text-sm mb-0">A new issue has been reported for Argon.</p>
                      </div>
                    </div>
                  </a>
                </div>
                <a href="#!" class="dropdown-item text-center text-primary font-weight-bold py-3">View all</a>
              </div>
            </li> -->
            
            <!-- <li class="nav-item dropdown">
              <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="ni ni-ungroup"></i>
              </a>
              <div class="dropdown-menu dropdown-menu-lg dropdown-menu-dark bg-default  dropdown-menu-right ">
                <div class="row shortcuts px-4">
                  <a href="#!" class="col-4 shortcut-item">
                    <span class="shortcut-media avatar rounded-circle bg-gradient-red">
                      <i class="ni ni-calendar-grid-58"></i>
                    </span>
                    <small>Calendar</small>
                  </a>
                  <a href="#!" class="col-4 shortcut-item">
                    <span class="shortcut-media avatar rounded-circle bg-gradient-orange">
                      <i class="ni ni-email-83"></i>
                    </span>
                    <small>Email</small>
                  </a>
                  <a href="#!" class="col-4 shortcut-item">
                    <span class="shortcut-media avatar rounded-circle bg-gradient-info">
                      <i class="ni ni-credit-card"></i>
                    </span>
                    <small>Payments</small>
                  </a>
                  <a href="#!" class="col-4 shortcut-item">
                    <span class="shortcut-media avatar rounded-circle bg-gradient-green">
                      <i class="ni ni-books"></i>
                    </span>
                    <small>Reports</small>
                  </a>
                  <a href="#!" class="col-4 shortcut-item">
                    <span class="shortcut-media avatar rounded-circle bg-gradient-purple">
                      <i class="ni ni-pin-3"></i>
                    </span>
                    <small>Maps</small>
                  </a>
                  <a href="#!" class="col-4 shortcut-item">
                    <span class="shortcut-media avatar rounded-circle bg-gradient-yellow">
                      <i class="ni ni-basket"></i>
                    </span>
                    <small>Shop</small>
                  </a>
                </div>
              </div>
            </li> -->
          </ul>
          <ul class="navbar-nav align-items-center  ml-auto ml-md-0 ">
            <li class="nav-item dropdown">
              <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <div class="media align-items-center">
                  @if (!auth()->user()->imagen)
                  <span class="avatar avatar-sm rounded-circle">
                    <img alt="Image placeholder" src="{{ asset ('img/theme/team-4.jpg') }}">
                  </span>
                  @else
                  <span class="avatar avatar-sm rounded-circle">
                    <img alt="Image placeholder" src="{{ asset ('uploads/'.auth()->user()->imagen) }}">
                  </span>
                  @endif
                  <div class="media-body  ml-2  d-none d-lg-block">
                    <span class="mb-0 text-sm  font-weight-bold">{{ auth()->user()->username }}</span>
                  </div>
                </div>
              </a>
              <div class="dropdown-menu  dropdown-menu-right ">
                <div class="dropdown-divider"></div>
                <a href="{{ route('logout') }}" class="dropdown-item">
                <svg style="height:20px;width:20px" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
              </svg>

                  <span>Logout</span>
                </a>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    @endauth
    <!-- Header -->


    @auth  
    <!-- Header -->
<div class="header bg-primary pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
              <li class="breadcrumb-item"><a><i class="fas fa-home"></i></a></li>
              <li class="breadcrumb-item"><a href="/" >Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">@yield('navegacion')</li>
            </ol>
          </nav>
        </div>
        <div class="col-lg-6 col-5 text-right">
          <a class="btn btn-sm btn-neutral">Nubia Cantú</a>
          <a class="btn btn-sm btn-neutral">Lorena Romero</a>
        </div>
      </div>
      @endauth

      
      @yield('contenido')

      @auth  
    </div>
  </div>
</div>
@endauth



@auth 
<!-- Page content -->
<div class="container-fluid mt--6">
  
  <!-- Footer -->
  <footer class="footer pt-0">
    <div class="row align-items-center justify-content-lg-between">
      <div class="col-lg-6">
        <div class="copyright text-center  text-white text-lg-left  text-muted">
          &copy; 2023 
        </div>
      </div>
    </div>
  </footer>
</div>

@endauth


    
  </div>
  <!-- Argon Scripts -->
  <!-- Argon Scripts -->
<!-- Core -->
<script src="{{ asset('jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js-cookie/js.cookie.js') }}"></script>
<script src="{{ asset('jquery.scrollbar/jquery.scrollbar.min.js') }}"></script>
<script src="{{ asset('jquery-scroll-lock/dist/jquery-scrollLock.min.js') }}"></script>

<!-- Optional JS -->
<script src="{{ asset('chart.js/dist/Chart.min.js') }}"></script>
<script src="{{ asset('chart.js/dist/Chart.extension.js') }}"></script>

  <!-- Argon JS -->
  @vite('resources/js/argon.js')

  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
  <script src="{{ asset('select2/dist/js/select2.min.js') }}"></script>

 
  @yield('js')

  <script>
    // Agregar evento click a los elementos del menú
$(document).ready(function() {
    $('.nav-link').click(function() {
        // Remover la clase active de todos los elementos
        $('.nav-link').removeClass('active');
        
        // Agregar la clase active al elemento clickeado
        $(this).addClass('active');
        
        // Guardar el estado activo en el almacenamiento local
        localStorage.setItem('activeNavItem', $(this).attr('href'));
    });
    
    // Restaurar el estado activo al cargar la página
    var activeNavItem = localStorage.getItem('activeNavItem');
    if (activeNavItem) {
        $('.nav-link[href="' + activeNavItem + '"]').addClass('active');
    }
});

</script>
  


</body>

</html>
