@extends('layouts.app')

@section('titulo')
Crea una cuenta
@endsection

@section('contenido_top')

@endsection

@section('contenido')
<!-- Navbar -->
<nav id="navbar-main" class="navbar navbar-horizontal navbar-transparent navbar-main navbar-expand-lg navbar-light">
    <div class="container">
      <a class="navbar-brand" href="{{ route('home') }}">
        <img src="{{ asset ('img/ventas.png') }}">
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-collapse" aria-controls="navbar-collapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="navbar-collapse navbar-custom-collapse collapse" id="navbar-collapse">
        <div class="navbar-collapse-header">
          <div class="row">
            <div class="col-6 collapse-brand">
              <a href="#">
                <img src="{{ asset ('img/ventas.png') }}">
              </a>
            </div>
            <div class="col-6 collapse-close">
              <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbar-collapse" aria-controls="navbar-collapse" aria-expanded="false" aria-label="Toggle navigation">
                <span></span>
                <span></span>
              </button>
            </div>
          </div>
        </div>
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a href="{{route('login')}}" class="nav-link">
              <span class="nav-link-inner--text">Iniciar Sesión</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <span class="nav-link-inner--text">Crear cuenta</span>
            </a>
          </li>
        </ul>
        <hr class="d-lg-none" />
        <ul class="navbar-nav align-items-lg-center ml-lg-auto">
          
          <li class="nav-item">
            <a class="nav-link nav-link-icon" href="https://github.com/MarisolRmr/ventas" target="_blank" data-toggle="tooltip" data-original-title="We're on Github">
              <i class="fab fa-github"></i>
              <span class="nav-link-inner--text d-lg-none">Github</span>
            </a>
          </li>
          
        </ul>
      </div>
    </div>
  </nav>

  <!-- Main content -->
  <div class="main-content">
    <!-- Header -->
    <div class="header bg-gradient-primary py-7 py-lg-8 pt-lg-9">
      <div class="container">
        <div class="header-body text-center mb-7">
          <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-8 px-5">
              <h1 class="text-white">Crea una cuenta</h1>
              <p class="text-lead text-white">Ingresa los siguientes datos para poder acceder</p>
            </div>
          </div>
        </div>
      </div>
      <div class="separator separator-bottom separator-skew zindex-100">
        <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
          <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
        </svg>
      </div>
    </div>
    <!-- Page content -->
    <div class="container mt--8 pb-5">
      <!-- Table -->
      <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
          <div class="card bg-secondary border-0">
            <div class="card-header bg-transparent pb-5">
              <!--
              <div class="text-muted text-center mt-2 mb-4"><small>Regístrate con</small></div>
              <div class="text-center">
                <a href="#" class="btn btn-neutral btn-icon mr-4">
                  <span class="btn-inner--icon"><img src="{{ asset ('img/icons/common/github.svg') }}"></span>
                  <span class="btn-inner--text">Github</span>
                </a>
                <a href="#" class="btn btn-neutral btn-icon">
                  <span class="btn-inner--icon"><img src="{{ asset ('img/icons/common/google.svg') }}"></span>
                  <span class="btn-inner--text">Google</span>
                </a>
              </div>
            </div>
            <div class="card-body px-lg-5 py-lg-5">
              <div class="text-center text-muted mb-4">
                <small>O regístrate con credenciales</small>
              </div>-->
              <form action="{{ route('register') }}" method="POST" class="mt-4" novalidate>
                @csrf

                <div class="form-group">
                  <div class="input-group input-group-merge input-group-alternative mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-hat-3"></i></span>
                    </div>
                    <input id="name" name="name" class="form-control @error('name') border-red-500 @enderror" value="{{ old('name') }}" placeholder="Nombre" type="text">
                    @error('name')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }} </p>
                    @enderror
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group input-group-merge input-group-alternative mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-hat-3"></i></span>
                    </div>
                    <input id="username" name="username" class="form-control @error('username') border-red-500 @enderror" value="{{ old('username') }}" placeholder="Username" type="text">
                    @error('username')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }} </p>
                    @enderror
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group input-group-merge input-group-alternative mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                    </div>
                    <input id="email" name="email" class="form-control @error('email') border-red-500 @enderror" value="{{ old('email') }}" placeholder="Email" type="email">
                    @error('email')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }} </p>
                    @enderror
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group input-group-merge input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                    </div>
                    <input id="password" name="password" class="form-control @error('password') border-red-500 @enderror" placeholder="Password" type="password">
                    @error('password')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }} </p>
                    @enderror
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group input-group-merge input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                    </div>
                    <input id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Repetir Password" type="password">
                    @error('password_confirmation')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }} </p>
                    @enderror
                  </div>
                </div>
                <!--<div class="text-muted font-italic"><small>password strength: <span class="text-success font-weight-700">strong</span></small></div>-->
                <div class="row my-4">
                  <div class="col-12">
                    <div class="custom-control custom-control-alternative custom-checkbox">
                      <input class="custom-control-input" id="customCheckRegister" type="checkbox">
                      <label class="custom-control-label" for="customCheckRegister">
                        <span class="text-muted">Estoy de acuerdo <a href="https://github.com/MarisolRmr/ventas" target="_blank"> con las política de privacidad</a></span>
                      </label>
                    </div>
                  </div>
                </div>
                <div class="text-center">
                  <button type="submit" class="btn btn-primary mt-4">Crear cuenta</button>
                </div>
              </form>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="py-5" id="footer-main">
    <div class="container">
      <div class="row align-items-center justify-content-xl-between">
        <div class="col-xl-6">
          <div class="copyright text-center text-xl-left text-muted">
            &copy; 2023 <a href="#" class="font-weight-bold ml-1" target="_blank">Nubia Esmeralda Cantú Sanchez</a>
          </div>
        </div>
        <div class="col-xl-4">
            <div class="copyright text-center text-xl-left text-muted">
             <a href="#" class="font-weight-bold ml-1" target="_blank">Lorena Marisol Romero Hernández</a>
            </div>
        </div>
      </div>
    </div>
  </footer>

@endsection