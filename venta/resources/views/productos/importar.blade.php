@extends('layouts.app')

@section('estilos')
<style>
    input:focus {
        outline-color: #5e72e4;
    }
    textarea:focus {
        outline-color: #5e72e4;
    }
    select:focus {
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
<!--directiva para integrar los estilos de dropzone-->
@push('styles')
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
@endpush

@section('navegacion')
Agregar Producto
@endsection

@section('contenido')
<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">
      <div class="card mb-4">
        <div class="card-header pb-0 mb-2 text-center">
          <h4>Importar CSV de Productos</h4>
        </div>
        <div class="card-body px-4 pt-4 pb-2 flex items-center justify-center text-center">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
          
            <form action="{{ route('productos.importar') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="archivo_csv">
                
                <div class="text-center">
                    <button type="submit"class="h-2 flex gap-2 btn btn-primary my-4 p-2 text-white hover:text-white">Importar</button>
                    <button type="button"class="h-2 flex gap-2 btn btn-secondary my-4 p-2 text-black hover:text-white"><a href="{{route('productos.index')}}">Cancelar</a></button>
                  </div>
            </form>

        </div>
      </div>
    </div>
  </div>
</div>
@endsection
