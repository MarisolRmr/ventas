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

    /* Estilos para el campo de entrada de archivo personalizado */
    .custom-file-input {
        opacity: 0;
        width: 0.1px;
        height: 0.1px;
        position: absolute;
        z-index: -1;
    }

    .custom-file-label {
        display: inline-block;
        padding: 0.5em 1em;
        font-size: 1rem;
        font-weight: 500;
        color: #fff;
        background-color: #333;
        border-radius: 0.25rem;
        cursor: pointer;
    }

    /* Cambiar el estilo cuando el mouse pasa por encima */
    .custom-file-label:hover {
        background-color: #555;
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
            <script>
                Swal.fire({
                    title: 'Éxito',
                    text: '{{ session('success') }}',
                    icon: 'success',
                    timer: 4000, 
                    timerProgressBar: true,
                    showConfirmButton: false,
                    
                });
            </script>
            @endif

            @if(session('error'))
            <script>
                Swal.fire({
                    title: 'Error',
                    text: '{{ session('error') }}',
                    icon: 'error',
                    timer: 4000, 
                    timerProgressBar: true,
                    showConfirmButton: false,
                    
                });
            </script>
            @endif

      
            <form action="{{ route('productos.importar') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" class="h-2 flex gap-2 btn btn-secondary my-4 p-2 text-black hover:text-white" name="archivo_csv">
                
                <div class="text-center">
                    <button type="submit"class="h-2 flex gap-2 btn btn-primary my-4 p-2 text-white hover:text-white">Importar</button>
                    <button type="button"class="h-2 flex gap-2 btn btn-secondary my-4 p-2 text-black hover:text-white"><a href="{{route('productos.index')}}">Cancelar</a></button>
                    <button type="button"class="h-2 flex gap-2 btn btn-secondary my-4 p-2 text-black hover:text-white"><a href="{{route('productos.index')}}">Ver Productos</a></button>
                    <button type="button" class="h-2 flex gap-2 btn btn-secondary my-4 p-2 text-black hover:text-white">
                        <a href="{{ asset('archivo.csv') }}" download>Descargar ejemplo</a>
                    </button>

                  </div>
            </form>

            <div class="h-2 flex gap-2 btn btn-secondary my-4 p-2 text-black hover:text-white" style="text-align: justify;">
                <h2>Instrucciones para la Importación de Productos</h2>
                <p>Asegúrate de seguir estas instrucciones antes de subir el archivo CSV:</p>
                
                <ol>
                    <li>El archivo CSV debe tener la siguiente estructura de columnas en el mismo orden:</li>
                </ol>
                
                <div class="csv-structure">
                    <code>nombre, precio_venta, precio_compra, unidades, categoria_id, subcategoria_id, marca_id, imagen</code>
                </div>
                
                <p>Cada columna debe contener los siguientes tipos de datos:</p>
                
                <ul>
                    <li><code>nombre</code>: Nombre del producto (texto).</li>
                    <li><code>precio_venta</code>: Precio de venta del producto (decimal, por ejemplo, 100.00).</li>
                    <li><code>precio_compra</code>: Precio de compra del producto (decimal, por ejemplo, 80.00).</li>
                    <li><code>unidades</code>: Cantidad de unidades disponibles del producto (entero, por ejemplo, 50).</li>
                    <li><code>categoria_id</code>: ID de la categoría del producto (entero, por ejemplo, 1).</li>
                    <li><code>subcategoria_id</code>: ID de la subcategoría del producto (entero, por ejemplo, 2).</li>
                    <li><code>marca_id</code>: ID de la marca del producto (entero, por ejemplo, 3).</li>
                    <li><code>imagen</code>: Nombre del archivo de imagen del producto (texto, por ejemplo, imagen1.jpg).</li>
                </ul>
                
                <p>Recuerda que:</p>
                
                <ul>
                    <li>Los valores numéricos deben estar en el formato correcto y sin separadores de miles.</li>
                    <li>Los campos de texto pueden contener letras, números y símbolos, excepto comas (`,`).</li>
                </ul>
                
                <p>Si el archivo CSV no cumple con esta estructura, la importación no se realizará correctamente.</p>
            </div>
            


            

        </div>
      </div>
    </div>
  </div>
</div>
@endsection
