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
    
</style>
@endsection

@section('navegacion')
    Editar Devolución
@endsection

@section('contenido')
<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">
      <div class="card mb-4">
        <div class="card-header pb-0 mb-2 text-center">
          <h4>Editar devolución</h4>
        </div>
        <div class="card-body px-4 pt-4 pb-2 flex items-center justify-center text-center">
          
            <form action="{{route('devoluciones.imagen')}}" method="post" enctype="multipart/form-data" id="dropzone" class="dropzone " style="width: 100%; border:none;padding:0px; align-items:center">
                @csrf
            </form>   
            
            <form action="{{route('devoluciones.update', $devolucion->id)}}" method="post" novalidate>
            @csrf
            
            <div class="mb-5" style="display: flex; align-items: top; justify-content:center">
                <label for="producto" class="mb-2 block uppercase text-gray-500 font-bold">
                    Nombre del Producto
                </label>
                <select 
                    style="border-radius: 20px !important; height: 50px; width: 400px; margin-left: 20px; "
                    id="producto"
                    name="producto"
                    class="border p-3 w-full rounded-lg @error ('producto') border-red-500 @enderror"
                    value="{{old('producto', $devolucion->producto)}}"
                >
                    <option value="">Seleccione el producto a devolver</option>
                    @foreach($productos as $producto)
                        <option value="{{$producto->id}}">{{$producto->nombre}}</option>
                    @endforeach
                </select>
                @error('producto')
                    <p style="background-color: #f56565; color: #fff;margin-top: 0.5rem;border-radius: 0.5rem;font-size: 0.875rem; padding: 0.5rem; text-align: center;" class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                        {{$message}}
                    </p>    
                @enderror
            </div>

            <div class="mb-5" style="display: flex; align-items: top; justify-content:center">
                <label for="fecha" class="mb-2 block uppercase text-gray-500 font-bold">
                    Fecha
                </label>
                <input 
                    style="border-radius: 20px !important; height: 45px; width: 400px; margin-left: 20px; "
                    id="fecha"
                    name="fecha"
                    type="date"
                    placeholder="Fecha"
                    class="border p-3 w-full rounded-lg @error ('fecha') border-red-500 @enderror"
                    value="{{old('fecha', $devolucion->fecha)}}"
                >
                @error('fecha')
                    <p style="background-color: #f56565; color: #fff;margin-top: 0.5rem;border-radius: 0.5rem;font-size: 0.875rem; padding: 0.5rem; text-align: center;" class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                        {{$message}}
                    </p>    
                @enderror
            </div>

            <div class="mb-5" style="display: flex; align-items: top; justify-content:center">
                <label for="cliente" class="mb-2 block uppercase text-gray-500 font-bold">
                    Cliente
                </label>
                <select 
                    style="border-radius: 20px !important; height: 50px; width: 400px; margin-left: 20px; "
                    id="cliente"
                    name="cliente"
                    class="border p-3 w-full rounded-lg @error ('cliente') border-red-500 @enderror"
                    value="{{old('cliente', $devolucion->cliente)}}"
                >
                    <option value="">Seleccione el cliente</option>
                    @foreach($clientes as $cliente)
                        <option value="{{$cliente->id}}">{{$cliente->nombre}}</option>
                    @endforeach
                </select>
                @error('cliente')
                    <p style="background-color: #f56565; color: #fff;margin-top: 0.5rem;border-radius: 0.5rem;font-size: 0.875rem; padding: 0.5rem; text-align: center;" class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                        {{$message}}
                    </p>    
                @enderror
            </div>

            <div class="mb-4 items-start" style="display: flex; align-items: top; justify-content:center">
                <label for="status" class="mb-2 block uppercase text-gray-500 font-bold">
                    Status
                </label>
                <select 
                    style="border-radius: 20px !important; height: 50px; width: 400px; margin-left: 20px; "
                    id="status"
                    name="status"
                    class="border p-3 w-full rounded-lg @error ('status') border-red-500 @enderror"
                    value="{{old('status' , $devolucion->status)}}"
                >
                    <option value="">Seleccione el status</option>
                    <option value="recibido">Recibido</option>
                    <option value="pendiente">Pendiente</option>
                    
                </select>
                @error('status')
                <p style="background-color: #f56565; color: #fff;margin-top: 0.5rem;border-radius: 0.5rem;font-size: 0.875rem; padding: 0.5rem; text-align: center;" class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                        {{$message}}
                    </p>    
                @enderror
            </div>

            <div class="mb-4 items-start" style="display: flex; align-items: top; justify-content:center">
                <label for="apagar" class="mb-2 block uppercase text-gray-500 font-bold">
                    Total a pagar
                </label>
                <input 
                    style="border-radius: 20px !important; height: 50px; width: 400px; margin-left: 20px; "
                    id="apagar"
                    name="apagar"
                    placeholder="Total a pagar"
                    class="border p-3 w-full rounded-lg @error ('apagar') border-red-500 @enderror"
                    value="{{old('apagar', $devolucion->apagar)}}"
                >

                @error('apagar')
                <p style="background-color: #f56565; color: #fff;margin-top: 0.5rem;border-radius: 0.5rem;font-size: 0.875rem; padding: 0.5rem; text-align: center;" class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                        {{$message}}
                    </p>    
                @enderror
            </div>

            <div class="mb-4 items-start" style="display: flex; align-items: top; justify-content:center">
                <label for="pagado" class="mb-2 block uppercase text-gray-500 font-bold">
                   Pagado
                </label>
                <input 
                    style="border-radius: 20px !important; height: 50px; width: 400px; margin-left: 20px; "
                    id="pagado"
                    name="pagado"
                    class="border p-3 w-full rounded-lg @error ('pagado') border-red-500 @enderror"
                    placeholder="Pagado"
                    value="{{old('pagado', $devolucion->pagado)}}"
                >
            
                @error('pagado')
                <p style="background-color: #f56565; color: #fff;margin-top: 0.5rem;border-radius: 0.5rem;font-size: 0.875rem; padding: 0.5rem; text-align: center;" class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                        {{$message}}
                    </p>    
                @enderror
            </div>

            <div class="mb-4 items-start" style="display: flex; align-items: top; justify-content:center">
                <label for="deuda" class="mb-2 block uppercase text-gray-500 font-bold">
                   Deuda
                </label>
                <input 
                    style="border-radius: 20px !important; height: 50px; width: 400px; margin-left: 20px; "
                    id="deuda"
                    name="deuda"
                    class="border p-3 w-full rounded-lg @error ('deuda') border-red-500 @enderror"
                    placeholder="Deuda"
                    value="{{old('deuda', $devolucion->deuda)}}"
                >
            
                @error('deuda')
                <p style="background-color: #f56565; color: #fff;margin-top: 0.5rem;border-radius: 0.5rem;font-size: 0.875rem; padding: 0.5rem; text-align: center;" class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                        {{$message}}
                    </p>    
                @enderror
            </div>

            <div class="mb-4 items-start" style="display: flex; align-items: top; justify-content:center">
                <label for="status2" class="mb-2 block uppercase text-gray-500 font-bold">
                    Status
                </label>
                <select 
                    style="border-radius: 20px !important; height: 50px; width: 400px; margin-left: 20px; "
                    id="status2"
                    name="status2"
                    class="border p-3 w-full rounded-lg @error ('status2') border-red-500 @enderror"
                    value="{{old('status2', $devolucion->status2)}}"
                >
                    <option value="">Seleccione el status</option>
                    <option value="recibido">Pagado</option>
                    <option value="pendiente">No pagado</option>
                    
                </select>
                @error('status2')
                <p style="background-color: #f56565; color: #fff;margin-top: 0.5rem;border-radius: 0.5rem;font-size: 0.875rem; padding: 0.5rem; text-align: center;" class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                        {{$message}}
                    </p>    
                @enderror
            </div>
            
            <!--Agregar campo oculto para guardar el valor de la imagen-->
            <div class="mb-5">
                <input type="hidden" name="imagen" id="imagen" value="{{old('imagen', $devolucion->imagen)}}">
                @error('imagen')
                <p style="background-color: #f56565; color: #fff;margin-top: 0.5rem;border-radius: 0.5rem;font-size: 0.875rem; padding: 0.5rem; text-align: center;" class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                        {{$message}}
                    </p>    
                @enderror
            </div>
            
            <div class="text-center">
              <button type="submit"class="h-2 flex gap-2 btn btn-primary my-4 p-2 text-white hover:text-white">Guardar</button>
              <button type="button"class="h-2 flex gap-2 btn btn-secondary my-4 p-2 text-black hover:text-white"><a href="{{route('devoluciones.index')}}">Cancelar</a></button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
