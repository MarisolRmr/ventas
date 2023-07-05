@extends('layouts.app')

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
    
</style>
@endsection

@section('contenido')
<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">
      <div class="card mb-4">
        <div class="card-header pb-0 mb-2 text-center">
          <h4>Agregar una nueva categoría</h4>
        </div>
        <div class="card-body px-4 pt-4 pb-2 flex items-center justify-center text-center">
          <form action="{{route('categorias.store')}}" method="post" novalidate>
            @csrf
            <div class="mb-5" style="display: flex; align-items: top; justify-content:center">
                <label for="nombre" class="mb-2 block uppercase text-gray-500 font-bold">
                    Nombre
                </label>
                <input 
                    style="border-radius: 20px !important; height: 45px; width: 400px; margin-left: 20px; "
                    id="nombre"
                    name="nombre"
                    type="text"
                    placeholder="Nombre de la categoría"
                    class="border p-3 w-full rounded-lg @error ('nombre') border-red-500 @enderror"
                    value="{{old('nombre')}}"
                >
                @error('nombre')
                    <p style="background-color: #f56565; color: #fff;margin-top: 0.5rem;border-radius: 0.5rem;font-size: 0.875rem; padding: 0.5rem; text-align: center;" class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                        {{$message}}
                    </p>    
                @enderror
            </div>

            <div class="mb-5" style="display: flex; align-items: top; justify-content:center">
                <label for="codigo" class="mb-2 block uppercase text-gray-500 font-bold">
                    Código
                </label>
                <input 
                    style="border-radius: 20px !important; height: 45px; width: 400px; margin-left: 20px; "
                    id="codigo"
                    name="codigo"
                    type="text"
                    placeholder="Código de la categoría"
                    class="border p-3 w-full rounded-lg @error ('codigo') border-red-500 @enderror"
                    value="{{old('codigo')}}"
                >
                @error('codigo')
                    <p style="background-color: #f56565; color: #fff;margin-top: 0.5rem;border-radius: 0.5rem;font-size: 0.875rem; padding: 0.5rem; text-align: center;" class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                        {{$message}}
                    </p>    
                @enderror
            </div>

            <div class="mb-4 items-start" style="display: flex; align-items: top; justify-content:center">
                <label for="descripcion" class="mb-2 block uppercase text-gray-500 font-bold">
                    Descripción
                </label>
                <textarea 
                    style="border-radius: 20px !important; height: 100px; width: 400px; margin-left: 20px; "
                    id="descripcion"
                    name="descripcion"
                    type="text"
                    placeholder="Descripción de la categoría"
                    class="border p-3 w-full rounded-lg "
                    value="{{old('descripcion')}}"
                ></textarea>
                @error('descripcion')
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