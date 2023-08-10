@extends('layouts.app')
<!--directiva para integrar los estilos de dropzone-->
@push('styles')
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
@endpush

@section('estilos')
<style>
    input:focus {
        outline-color: #5e72e4;
    }
    textarea:focus {
        outline-color: #5e72e4;
    }

    input {
        border-radius: 20px;
    }
    .mb-5 label {
        margin-bottom: 0.5rem;
        
    }
    .dropzone.dz-clickable .dz-message, .dropzone.dz-clickable .dz-message * {
        width: 400px !important;
    }
    .dz-image img{
        height: 120px !important;
        width: 120px !important;
    }
    
</style>
@endsection

@section('contenido')
<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">
      <div class="card mb-4">
        <div class="card-header pb-0 mb-2 text-center">
          <h4>Editar usuario</h4>
        </div>
        <div class="card-body px-4 pt-4 pb-2 flex items-center justify-center text-center">
          
            <form action="{{route('imagenes.store')}}" method="post" enctype="multipart/form-data" id="dropzone" class="dropzone " style="width: 100%; border:none;padding:0px; align-items:center">
                @csrf
            </form>   
            <form action="{{ route('usuarios.update', $usuario->id) }}" method="post" novalidate>
            @csrf
            <div class="mb-5" style="display: flex; align-items: top; justify-content:center">
                <label for="nombre" class="mb-2 block uppercase text-gray-500 font-bold">
                    Nombre
                </label>
                <input 
                    style="border-radius: 20px !important; height: 45px; width: 400px; margin-left: 20px; "
                    id="nombre"
                    name="name"
                    type="text"
                    placeholder="Nombre del usuario"
                    class="border p-3 w-full rounded-lg @error ('name') border-red-500 @enderror"
                    value="{{$usuario->name}}"
                >
                @error('name')
                    <p style="background-color: #f56565; color: #fff;margin-top: 0.5rem;border-radius: 0.5rem;font-size: 0.875rem; padding: 0.5rem; text-align: center;" class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                        {{$message}}
                    </p>    
                @enderror
            </div>

            <div class="mb-5" style="display: flex; align-items: top; justify-content:center">
                <label for="apellido" class="mb-2 block uppercase text-gray-500 font-bold">
                    Apellido
                </label>
                <input 
                    style="border-radius: 20px !important; height: 45px; width: 400px; margin-left: 20px; "
                    id="apellido"
                    name="apellido"
                    type="text"
                    placeholder="Apellido del usuario"
                    class="border p-3 w-full rounded-lg @error ('apellido') border-red-500 @enderror"
                    value="{{ $usuario->apellido}}"
                >
                @error('apellido')
                    <p style="background-color: #f56565; color: #fff;margin-top: 0.5rem;border-radius: 0.5rem;font-size: 0.875rem; padding: 0.5rem; text-align: center;" class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                        {{$message}}
                    </p>    
                @enderror
            </div>

            <div class="mb-5" style="display: flex; align-items: top; justify-content:center">
                <label for="telefono" class="mb-2 block uppercase text-gray-500 font-bold">
                    Telefono
                </label>
                <input 
                    style="border-radius: 20px !important; height: 45px; width: 400px; margin-left: 20px; "
                    id="telefono"
                    name="telefono"
                    type="text"
                    placeholder="Telefono del usuario"
                    class="border p-3 w-full rounded-lg @error ('telefono') border-red-500 @enderror"
                    value="{{ $usuario->telefono}}"
                >
                @error('telefono')
                    <p style="background-color: #f56565; color: #fff;margin-top: 0.5rem;border-radius: 0.5rem;font-size: 0.875rem; padding: 0.5rem; text-align: center;" class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                        {{$message}}
                    </p>    
                @enderror
            </div>

            <div class="mb-5" style="display: flex; align-items: top; justify-content:center">
                <label for="email" class="mb-2 block uppercase text-gray-500 font-bold">
                    Email
                </label>
                <input 
                    style="border-radius: 20px !important; height: 45px; width: 400px; margin-left: 20px; "
                    id="email"
                    name="email"
                    type="email"
                    placeholder="Email del usuario"
                    class="border p-3 w-full rounded-lg @error ('email') border-red-500 @enderror"
                    value="{{ $usuario->email}}"
                >
                @error('email')
                    <p style="background-color: #f56565; color: #fff;margin-top: 0.5rem;border-radius: 0.5rem;font-size: 0.875rem; padding: 0.5rem; text-align: center;" class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                        {{$message}}
                    </p>    
                @enderror
            </div>

            <div class="mb-5" style="display: flex; align-items: top; justify-content:center">
                <label for="username" class="mb-2 block uppercase text-gray-500 font-bold">
                    Username
                </label>
                <input 
                    style="border-radius: 20px !important; height: 45px; width: 400px; margin-left: 20px; "
                    id="username"
                    name="username"
                    type="text"
                    placeholder="Username del usuario"
                    class="border p-3 w-full rounded-lg @error ('username') border-red-500 @enderror"
                    value="{{ $usuario->username}}"
                >
                @error('username')
                    <p style="background-color: #f56565; color: #fff;margin-top: 0.5rem;border-radius: 0.5rem;font-size: 0.875rem; padding: 0.5rem; text-align: center;" class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                        {{$message}}
                    </p>    
                @enderror
            </div>

            <div class="mb-5" style="display: flex; align-items: top; justify-content:center">
                <label for="password" class="mb-2 block uppercase text-gray-500 font-bold">
                    Password
                </label>
                <input 
                    style="border-radius: 20px !important; height: 45px; width: 400px; margin-left: 20px; "
                    id="password"
                    name="password"
                    type="password"
                    placeholder="Password del usuario"
                    class="border p-3 w-full rounded-lg @error ('password') border-red-500 @enderror"
                    value=""
                >
                @error('password')
                    <p style="background-color: #f56565; color: #fff;margin-top: 0.5rem;border-radius: 0.5rem;font-size: 0.875rem; padding: 0.5rem; text-align: center;" class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                        {{$message}}
                    </p>    
                @enderror
            </div>

            <div class="mb-5" style="display: flex; align-items: top; justify-content:center">
                <label for="status" class="mb-2 block uppercase text-gray-500 font-bold">
                    Status
                </label>
                <select 
                    style="border-radius: 20px !important; height: 50px; width: 400px; margin-left: 20px; "
                    id="status"
                    name="status"
                    class="border p-3 w-full rounded-lg @error ('status') border-red-500 @enderror"
                >
                    <option value="">Seleccione el status</option>
                    <option value="Activado" {{ $usuario->status === 'Activado' ? 'selected' : '' }}>Activado</option>
                    <option value="Desactivado" {{ $usuario->status === 'Desactivado' ? 'selected' : '' }}>Desactivado</option>
                </select>
                @error('status')
                    <p style="background-color: #f56565; color: #fff;margin-top: 0.5rem;border-radius: 0.5rem;font-size: 0.875rem; padding: 0.5rem; text-align: center;" class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                        {{$message}}
                    </p>    
                @enderror
            </div>

            <div class="mb-5" style="display: flex; align-items: top; justify-content:center">
                <label for="rol" class="mb-2 block uppercase text-gray-500 font-bold">
                    Rol
                </label>
                <select 
                    style="border-radius: 20px !important; height: 50px; width: 400px; margin-left: 20px; "
                    id="rol"
                    name="rol"
                    class="border p-3 w-full rounded-lg @error ('rol') border-red-500 @enderror"
                >
                    <option value="">Seleccione el Rol</option>
                    <option value="Administrador" {{ $usuario->rol === 'Administrador' ? 'selected' : '' }}>Administrador</option>
                    <option value="Vendedor" {{ $usuario->rol === 'Vendedor' ? 'selected' : '' }}>Vendedor</option>
                </select>
                @error('rol')
                    <p style="background-color: #f56565; color: #fff;margin-top: 0.5rem;border-radius: 0.5rem;font-size: 0.875rem; padding: 0.5rem; text-align: center;" class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                        {{$message}}
                    </p>    
                @enderror
            </div>

            
            <!--Agregar campo oculto para guardar el valor de la imagen-->
            <div class="mb-5">
                <input type="hidden" name="imagen"  value="{{$usuario->imagen}}">
                @error('imagen')
                <p style="background-color: #f56565; color: #fff;margin-top: 0.5rem;border-radius: 0.5rem;font-size: 0.875rem; padding: 0.5rem; text-align: center;" class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                        {{$message}}
                    </p>    
                @enderror
            </div>
            
            <div class="text-center">
              <button type="submit"class="h-2 flex gap-2 btn btn-primary my-4 p-2 text-white hover:text-white">Guardar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
